<?php

use Core\Database;

class CreateUserShrineTable
{
    function up(Database $db)
    {
        $sql = "CREATE TABLE IF NOT EXISTS user_shrine (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            shrine_id INT NOT NULL,
            visited_at DATE NULL,  -- Date when the shrine was visited
            favorited TINYINT(1) DEFAULT 0,  -- 0 = No, 1 = Yes
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            UNIQUE KEY user_shrine_unique (user_id, shrine_id),
            
            CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            CONSTRAINT fk_shrine FOREIGN KEY (shrine_id) REFERENCES shrines(id) ON DELETE CASCADE
        );";

        try {
            $db->query($sql);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    function down(Database $db)
    {
        $sql = "DROP TABLE IF EXISTS user_shrine";

        try {
            $db->query($sql);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
