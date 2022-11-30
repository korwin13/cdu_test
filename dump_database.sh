#!/bin/bash

source ./config.sh
pg_dump -U $PG_USER -d $PG_DB > $PG_DUMP_DIR