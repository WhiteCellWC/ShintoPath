<?php

if ($argc < 2) {
    echo "Usage: php cli.php {command}\n";
    exit(1);
}

$command = $argv[1];
if (str_contains($command, 'make')) {
    [$command, $build] = explode(':', $argv[1]);
}

switch ($command) {
    case 'migrate':
        require __DIR__ . '/database/migration_runner.php';
        echo "Migrations executed successfully.\n";
        break;

    case 'refresh':
        require __DIR__ . '/database/migration_refresh.php';
        echo "Migrations refreshed successfully.\n";
        break;

    case 'make':
        switch ($build) {
            case "request":
                require __DIR__ . '/app/Console/MakeRequest.php';
                break;

            case "controller":
                require __DIR__ . '/app/Console/MakeController.php';
                break;

            case "model":
                require __DIR__ . '/app/Console/MakeModel.php';
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
