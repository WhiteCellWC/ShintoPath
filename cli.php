<?php

if ($argc < 2) {
    echo "Usage: php cli.php {command}\n";
    exit(1);
}

$command = $argv[1];

switch ($command) {
    case 'migrate':
        require __DIR__ . '/database/migration_runner.php';
        echo "Migrations executed successfully.\n";
        break;

    case 'refresh':
        // Example: Running migration refresh logic
        require __DIR__ . '/database/migration_refresh.php';
        echo "Migrations refreshed successfully.\n";
        break;

    case 'make':
        switch ($argv[2]) {
            case "request":
                echo $argv[3];
                break;

            default:
                echo "Unknown command: $command\n";
                exit(1);
        }
        break;

    default:
        echo "Unknown command: $command\n";
        exit(1);
}
