<?php

namespace App\Models;

use Core\App;
use Core\Database;

class Model
{
    protected string $table;

    protected array $fillable;

    protected array $hidden;

    protected array $cast;

    protected array $whereClauses = [];

    protected array $data;

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

    public static function where(string $column = 'id', $value = null)
    {
        if (!$value) {
            $value = $column;
            $column = "id";
        }

        $instance = new static();
        $instance->whereClauses[] = "$column = '$value'";
        return $instance;
    }

    public function andWhere(string $column = 'id', $value = null)
    {
        if (!$value) {
            $value = $column;
            $column = "id";
        }
        $this->whereClauses[] = "$column = '$value'";
        return $this;
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

    public function first()
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM $table";
        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }
        $this->data = App::resolve(Database::class)->query($sql)->fetch();
        return $this;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null; // Access data properties
    }

    public function get()
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }

        $results = App::resolve(Database::class)->query($sql)->fetchAll();
        $Collection = [];
        foreach ($results as $model) {
            $Collection[] = new static($model);
        }
        return $Collection;
    }
}
