<?php

namespace App\Models;

use Core\App;
use Core\Database;
use Core\QueryBuilder;

class Model
{
    protected string $table;

    protected array $fillable;

    protected array $hidden;

    protected array $cast;

    public function __construct(array $attributes = [])
    {
        $this->setDefaultTableName();

        foreach ($attributes as $key => $value) {
            if (!in_array($key, $this->hidden)) $this->{$key} = $value;
        }
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
    public static function create(array $data = [])
    {
        $instance = new static();
        $table = $instance->getTableName();

        $columns = implode(',', $instance->fillable);
        $placeholders = implode(',', array_map(fn($param) => ":$param", $instance->fillable));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        foreach ($instance->cast as $key => $value) {
            if ($value === "hashed") {
                $data[$key] = password_hash($data[$key], PASSWORD_BCRYPT);
            }
        }

        $db = App::resolve(Database::class)->query($sql, $data);

        $lastInsertId = $db->lastInsertId();

        $user = $db->query("SELECT * FROM {$table} WHERE id = :id", ['id' => $lastInsertId])->fetch();

        return $user ? new static($user) : null;
    }
}
