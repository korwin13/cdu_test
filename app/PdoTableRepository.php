<?php

namespace App;

class PdoTableRepository extends BasePdoRepository
{
    private $config;

    public function __construct(\PDO $pdo)
    {
        $this->tableName = "";
        $this->pdo = $pdo;
        $this->config = parse_config_sh("../config.sh");
        parent::__construct($pdo, $this->tableName);
    }

    public function create(array $row) : ?int
    {
        // not implemented
        return null;
    }

    public function query($sql) : array
    {
        $data = parent::query($sql);
        return $data;
    }

    public function duplicate($tableName) 
    {
        $schema = $this->config['PG_SCHEMA'];
        // get current number of tables
        $sql = "select count(*) as N from information_schema.tables 
            where table_schema = '$schema' and table_name like '$tableName%'"; 
        $data = $this->query($sql);
        $index = $data[0]['n'];
        $newTableName = $tableName.$index;

        $sql = "create table $newTableName as select * from $tableName;";
        $data = $this->query($sql);
        return $newTableName;
    }

   
}