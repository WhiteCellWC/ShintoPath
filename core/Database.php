<?php

namespace Core;

use PDO;

class Database
{
    public $connection;
    public $statement;

    function __construct($config)
    {
        $pdo = new PDO("{$config['default']}:host={$config['connections'][$config['default']]['host']}", $config['connections'][$config['default']]['username'], $config['connections'][$config['default']]['password']);
        $stmt = $pdo->query("SHOW DATABASES LIKE '{$config['connections'][$config['default']]['database']}'");
        if (!$stmt->fetch()) {
            $input = readline("Database '{$config['connections'][$config['default']]['database']}' does not exist. Create it? (yes/no): ");
            if (strtolower($input) === 'yes') {
                $sql = "CREATE DATABASE IF NOT EXISTS `{$config['connections'][$config['default']]['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                $pdo->exec($sql);
                echo "Database '{$config['connections'][$config['default']]['database']}' created successfully.\n";
            } else {
                echo "Migration aborted. Database does not exist.\n";
                die();
            }
        }
        $dsn = "{$config['default']}:host={$config['connections'][$config['default']]['host']};port={$config['connections'][$config['default']]['port']};dbname={$config['connections'][$config['default']]['database']};charset={$config['connections'][$config['default']]['charset']};";
        $this->connection = new PDO($dsn, $config['connections'][$config['default']]['username'], $config['connections'][$config['default']]['password']);
    }

    function connectionStatus()
    {
        return $this->connection;
    }
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

      public function fetch()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }
}
