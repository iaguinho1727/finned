from openai import OpenAI
import psycopg as pg
from psycopg import sql
from psycopg.rows import dict_row
from pydantic import BaseModel
import typing as t
import re
import json

import os
import base64
from pathlib import Path


SYSTEM_PROMPT="""
You are DBA Chatbot, an expert at analyzing database records and identifying duplicates.
Your role is to help clean duplicate records by grouping entries that refer to the same thing. You will be provided a JSON object containing all records from the database.
Your task is to return the groups of duplicates as lists, where each list contains the records that refer to the same thing.

### Example Input:
```json
{
    [
        {"id": 4, "name": "Uber Trip São Paulo"},
        {"id": 2, "name": "Uber"},
        {"id": 1, "name": "99"},
        {"id": 9, "name": "99 Transporte"}
    ]
}
```

### Example Output:
```json
{
    "data": [
        [
            {"id": 4, "name": "Uber Trip São Paulo"},
            {"id": 2, "name": "Uber"}
        ],
        [
            {"id": 1, "name": "99"},
            {"id": 9, "name": "99 Transporte"}
        ]
    ]
}
```

### Guidelines:
1. Focus on similarities in the **name** field to identify duplicates. Common patterns include:
   - Partial matches (e.g., "Uber" and "Uber Trip São Paulo").
   - Synonyms or abbreviations (e.g., "99" and "99 Transporte").
2. Ensure the output is formatted as valid JSON.
"""


class Participant(BaseModel):
    id: int
    name: str


class Response(BaseModel):
    data: list[list[Participant]]




def prompt(parcipants_list: str):
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

                ],

                "role": "user",
                "content": [
                    {
                    "type": "text",
                    "text": parcipants_list

                    }

                ]

            },
        ],
        "response_format": Response,
        "temperature": 1,
        "max_tokens": 16383,
        "top_p": 1,
        "frequency_penalty": 0,
        "presence_penalty": 0

    }
    print('Iniating prompt')
    # Make the API call (Replace 'client.chat.completions.create' with your actual API client method)
    return client.beta.chat.completions.parse(**response_payload)

# Print or handle the response








database=pg.connect('dbname=myfin password=123 host=localhost user=master')


def get_all_participants(c : pg.Cursor):
    c.execute('SELECT id,name FROM participants')
    return c.fetchall()

def delete_participant(id : int,c : pg.Cursor):
    c.execute('DELETE FROM participants WHERE id=%s',[id])

def delete_many_participants(participants : list[Participant],c : pg.Cursor):

    for pariticipant in participants:
        id=pariticipant.id

        delete_participant(id,c)

def update_many_movements_participants(new_participant : Participant,participants : list[Participant],c : pg.Cursor):
    participant_list=list(map(lambda item: item.id,participants))
    query=sql.SQL('UPDATE movements SET participant_id=%s WHERE participant_id IN ({in_clause})').format(in_clause=sql.SQL(',').join(participant_list))
    c.execute(query,[new_participant.id])

def select_participants(participants : list[dict],c : pg.Cursor):
    participant_list=list(map(lambda item: item['id'],participants))
    c.execute(sql.SQL('SELECT * FROM participants WHERE id IN ({})').format(sql.SQL(',').join(participant_list)))
    return c.fetchall()

with database.cursor(row_factory=dict_row) as c:

    participants=get_all_participants(c)
    json_string=json.dumps(participants)


    result=prompt(json_string)
    gpt_content=result.choices[0].message.parsed

    for group in gpt_content.data:
        first_participant=group[0]
        print('Updateing and deleting related fields')
        update_many_movements_participants(first_participant,group)
        delete_many_participants(group[1:],c)

    database.commit()






