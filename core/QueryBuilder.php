<?php

namespace Core;

use Core\App;
use Core\Database;

class QueryBuilder
{
    protected string $table;
    protected array $whereClauses = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function where(string $column, $value = null)
    {
        if (!$value) {
            $value = $column;
            $column = "id";
        }
        $this->whereClauses[] = "$column = '$value'";
        return $this;
    }

    public function get()
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }

        return App::resolve(Database::class)->query($sql)->fetchAll();
    }


    public function first()
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }

        return App::resolve(Database::class)->query($sql)->fetch();
    }
}
