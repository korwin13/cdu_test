<?php

namespace App;
		

class BasePdoRepository implements RepositoryInterface
{
	private $pdo;
    private $tableName;

    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }    

    public function create(array $row) : ?int
    {
    	$keys = array_keys($row);
    	$preparedRow = array_update_keys($row, fn ($k) => $k = ':'.$k);

    	$strKeys = implode(',', $keys);
        $strPreparedKeys = implode(',', array_keys($preparedRow));
    	$sql = "insert into $this->tableName ($strKeys) values($strPreparedKeys) returning id";

    	$stmt = $this->pdo->prepare($sql);
    	$stmt->execute($preparedRow);
    	return $this->pdo->lastInsertId();
    }

    public function query($sql) : array
    {
        $data = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    
}
