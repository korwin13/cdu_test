#!/bin/bash

source ./config.sh
if [ -n "$1" ]
then
	table=$1
else
	table="users"
fi

sql="select json_agg(t) from (select $table.* from $table) t;"
psql -U $PG_USER -d $PG_DB -t -A -q -c "$sql"