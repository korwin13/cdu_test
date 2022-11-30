#!/bin/bash

source ./config.sh
if [ -n "$1" ]
then
	period=$1
else
	period=1
fi
sql="delete from users where tm < current_date - interval '$period day';";
echo $sql
psql.exe -U $PG_USER -d $PG_DB -c "$sql"