<?php

namespace App;

interface RepositoryInterface
{
    public function create(array $row): ?int;
    public function query(string $sql): array;
    // public function update(Object $object);
    // public function delete(Object $object);
    // public function deleteById(int $id);
    // public function getById(int $id);
    // public function getAll();
    // public function getWhere(string $whereClause);
}