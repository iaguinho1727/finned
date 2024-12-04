from openai import OpenAI
import psycopg as pg
from psycopg.rows import dict_row
from pydantic import BaseModel
import typing as t
import re
import json

import os
import base64
from pathlib import Path


SYSTEM_PROMPT="""
You are the Financial Chatbot. Your task is to transform financial media, such as screenshots, receipts, or other related content, into a structured JSON response.

### Key Guidelines:
1. **You must always return an array of objects.**
2. **You must strictly follow conventional JSON structure rules**, including:
   - Floating point numbers must always use a period (`.`) as the decimal separator, never a comma (`,`).
3. **You must always use the following JSON response format:**

```json
[
  {
    "participant": "Transacional LTDA",
    "value": 123.45,
    "transaction_date": "2024-11-20",
    "installment": 1,
    "payment_type": "debit"
  }
]
```

### Detailed Description of Each Field:

- **`participant`**: The name associated with the transaction, typically located directly below the transaction value.
- **`value`**: The transaction amount, which can be either positive or negative. Use a period (`.`) as the decimal separator.
- **`transaction_date`**: The date of the transaction, formatted as `YYYY-MM-DD`.
- **`installment`**: Indicates the installment number. If not applicable, default to `1`.
- **`payment_type`**: Specifies the payment method. It must be one of the following options:
  - `pix`
  - `credit`
  - `debit`
  - `transfer`
  - `money`
  - `other`

### Notes:
- Ensure strict adherence to the provided JSON format.
- Any deviation from these instructions will result in incorrect responses.
"""

class Movement(BaseModel):
    movement_type: str
    movement_date: str
    installment: int
    value: float
    participant: str

def get_images():
    image_contents : list[tuple[dict,Path]] = []
    images_folder = Path('./images')
    # Loop through all files in the folder
    for image_file in images_folder.iterdir():
        if image_file.is_file() and image_file.suffix.lower() in ['.png', '.jpg', '.jpeg']:  # Filter image files
            print(f'Encoding image: {image_file}')
            with open(image_file, 'rb') as img:
                # Encode the image to base64
                encoded_image = base64.b64encode(img.read()).decode('utf-8')
                # Add the base64 string to the list
                base64_dict={
                    "type": "image_url",
                    "image_url": {
                        "url": f"data:image/{image_file.suffix[1:]};base64,{encoded_image}"
                    }
                }
                image_contents.append((base64_dict,image_file))
    return image_contents


def prompt(image_contents: dict):
    client = OpenAI(api_key='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')

# Path to your images folder


    # Initialize a list to store image data




    # Create the request payload
    response_payload = {
        "model": "gpt-4o",
        "messages": [
            {
                "role": "system",
                "content": [
                    {
                    "type": "text",
                    "text": SYSTEM_PROMPT

                    }

                ]

            },
            {
                "role": "user",
                "content": [image_contents]
            }
        ],
        "response_format": { "type": "text" },
        "temperature": 1,
        "max_tokens": 16383,
        "top_p": 1,
        "frequency_penalty": 0,
        "presence_penalty": 0

    }
    print('Iniating prompt')
    # Make the API call (Replace 'client.chat.completions.create' with your actual API client method)
    return client.chat.completions.create(**response_payload)

# Print or handle the response








database=pg.connect('dbname=myfin password=123 host=localhost user=master')

def get_parcipant_name(name : str,c : pg.cursor):
    c.execute(f"select id from participants WHERE name ILIKE %s OR name ILIKE %s OR name ILIKE %s;",[f'%{name}%',f'%{name}',f'{name}%'])

    return c.fetchone()

def insert_new_participant(name : str,c : pg.Cursor):
    c.execute(f'INSERT INTO participants (name) VALUES (%s) RETURNING id;',[name])
    return c.fetchone()


with database.cursor(row_factory=dict_row) as c:

    images=get_images()
    # for _,path_object in images:
    #     c.execute(f"INSERT INTO image_analysis (file) VALUES (%s) ",[path_object.stem])
    #     print(f'Inserting image into analysis Table: {path_object.stem}')

    #database.commit()


    for base64_dict,path_object in images:
        print('Prompting image')
        response=prompt(base64_dict)
        result : str=response.choices[0].message.content

        result=result.replace('```json','').replace('```','')

        with open(f'json/{path_object.stem}.json','w') as f:
            f.write(result)
        try:
            result_object : list[Movement]=json.loads(result)



            print(result_object)

            for row in result_object:
                print(f'Current row: {str(row)}')

                value=row['value']
                parcela=row['installment']
                movement_date=row['transaction_date']
                movement_type=row['payment_type']
                participant=row['participant']

                current_parcipant=get_parcipant_name(participant,c)
                if current_parcipant is None:
                    current_parcipant=insert_new_participant(participant,c)
                    print(f'Creating new Paricipant: {participant}')
                participant_id=current_parcipant['id']




                print(f'Inserting new movement: {str(row)}')
                c.execute(f"INSERT INTO movements (value,parcela,participant_id,movement_date,movement_type) VALUES\
                (%(value)s,%(parcela)s,%(participant_id)s,%(movement_date)s,%(movement_type)s);",
                {"value": value,"parcela": parcela,"participant_id":participant_id,"movement_date": movement_date ,"movement_type": movement_type})

                c.execute(f'UPDATE image_analysis SET analyzed=true WHERE file=%s',[path_object.stem])
                database.commit()

        except:
            continue



