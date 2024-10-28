<?php

use Core\App;
use Core\Database;

require __DIR__ . "/../bootstrap/app.php";

$db = App::resolve(Database::class);

foreach (glob(__DIR__ . '/migrations/*.php') as $migration) {
    if ($migration === "D:\All Projects\PurePHP\database\migrations/../migrations/migration_runner.php") {
        break;
    }

    require_once $migration;

    $classNameParts = array_slice(explode("_", basename($migration, '.php')), 4);
    $className = implode('', array_map('ucfirst', $classNameParts));

    echo "Running migration: $migration" . PHP_EOL;
    if (class_exists($className)) {
        $migrationClass = new $className();
        $migrationClass->up($db) . PHP_EOL;
    } else {
        echo "Class $className not found!" . PHP_EOL;
    }
}
