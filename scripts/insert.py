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








database=pg.connect('dbname=myfin password=123 host=localhost user=master')

def get_parcipant_name(name : str,c : pg.cursor):
    c.execute(f"select id from participants WHERE name ILIKE %s OR name ILIKE %s OR name ILIKE %s;",[f'%{name}%',f'%{name}',f'{name}%'])

    return c.fetchone()

def insert_new_participant(name : str,c : pg.Cursor):
    c.execute(f'INSERT INTO participants (name) VALUES (%s) RETURNING id;',[name])
    return c.fetchone()


with database.cursor(row_factory=dict_row) as c:

    files=os.listdir('json')

    for file in files:

        with open(f'json/{file}','r') as f:

            content=f.read()
            current_movement=json.loads(content)
            for movement in current_movement:
                parcela=1
                movement_type=movement['payment_type']
                participant=movement['participant']
                value=movement['value']
                movement_date=movement['transaction_date']

                current_parcipant=get_parcipant_name(participant,c)
                if current_parcipant is None:
                    current_parcipant=insert_new_participant(participant,c)
                    print(f'Creating new Paricipant: {participant}')
                participant_id=current_parcipant['id']


                print(f'insert new movement {str(current_movement)}')

                c.execute(f"INSERT INTO movements (value,parcela,participant_id,movement_date,movement_type) VALUES\
                (%(value)s,%(parcela)s,%(participant_id)s,%(movement_date)s,%(movement_type)s);",
                {"value": value,"parcela": parcela,"participant_id":participant_id,"movement_date": movement_date ,"movement_type": movement_type})
        database.commit()





