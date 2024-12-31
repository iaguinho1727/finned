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


with database.cursor(row_factory=dict_row) as c:
    movement_type='debit'
    movement_date='2024-12-08'
    value=88.10
    participant_id=595
    for i in range(1,5):
        c.execute(f"INSERT INTO movements (value,participant_id,movement_date,movement_type) VALUES\
                (%(value)s,%(participant_id)s,%(movement_date)s,%(movement_type)s);",
                {"value": value,"participant_id":participant_id,"movement_date": movement_date ,"movement_type": movement_type})
    database.commit()
