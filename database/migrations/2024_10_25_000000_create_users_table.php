<?php

use Core\Database;

class CreateUsersTable
{
    function up(Database $db)
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        try {
            $db->query($sql);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    function down(Database $db)
    {
        $sql = "DROP TABLE IF EXISTS users";

        try {
            $db->query($sql);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
