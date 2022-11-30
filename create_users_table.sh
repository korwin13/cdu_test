#!/bin/bash

source ./config.sh

sql="create TABLE IF NOT EXISTS users (id serial PRIMARY KEY, fio varchar, age int, hobby varchar, tm timestamp DEFAULT CURRENT_TIMESTAMP);"
psql -U $PG_USER -d $PG_DB -c "$sql"