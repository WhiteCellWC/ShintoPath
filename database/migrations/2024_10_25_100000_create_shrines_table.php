<?php

use Core\Database;

class CreateShrinesTable
{
    function up(Database $db)
    {
        $sql = "CREATE TABLE IF NOT EXISTS shrines (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            location VARCHAR(255) NOT NULL,
            prefecture VARCHAR(100) NOT NULL,
            established_year INT NULL,
            description TEXT,
            deity VARCHAR(100) NULL,
            website VARCHAR(255) NULL,
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
        $sql = "DROP TABLE IF EXISTS shrines";

        try {
            $db->query($sql);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
