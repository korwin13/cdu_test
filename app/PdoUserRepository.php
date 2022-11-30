<?php

namespace App;

class PdoUserRepository extends BasePdoRepository
{
    private $pdo;
    private $tableName;
    private $user;


    public function __construct(\PDO $pdo)
    {
        $this->tableName = "users";
        parent::__construct($pdo, $this->tableName);
    }

    
}