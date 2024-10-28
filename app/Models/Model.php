<?php

namespace App\Models;

use Core\App;
use Core\Database;
use Core\QueryBuilder;

class Model
{
    protected string $table;

    public function __construct()
    {
        $this->setDefaultTableName();
    }

    protected function setDefaultTableName()
    {
        if (!isset($this->table)) {
            $className = (new \ReflectionClass($this))->getShortName();
            $this->table = $this->pluralize($className);
        }
    }

    protected function pluralize(string $word): string
    {
        return preg_match('/(s|x|z|sh|ch)$/', $word) ? $word . 'es' : $word . 's';
    }

    public function getTableName()
    {
        return $this->table;
    }

    public static function where($column = 'id', $value = null)
    {
        $instance = new static();
        $queryBuilder = new QueryBuilder($instance->getTableName());

        if (is_null($value)) {
            $value = $column;
            $column = 'id';
        }

        return $queryBuilder->where($column, $value);
    }

    public static function all()
    {
        $instance = new static();
        $sql = "SELECT * FROM {$instance->getTableName()}";
        return App::resolve(Database::class)->query($sql)->fetchAll();
    }
}
