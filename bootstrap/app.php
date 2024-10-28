<?php

use Core\App;
use Core\Container;
use Core\Database;

require __DIR__ . '/../core/HelperFunctions.php';

require basepath('vendor/autoload.php');

$container = new Container();

$container->bind(Database::class, function () {
    $config = require basepath('config/database.php');

    return new Database($config);
});

App::setContainer($container);