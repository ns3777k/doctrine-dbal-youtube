<?php

use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/vendor/autoload.php';

$connection = DriverManager::getConnection([
    'url' => 'postgres://postgres:12345@127.0.0.1:5432/postgres?sslmode=disable&charset=utf8'
]);

var_dump($connection->createSchemaManager()->listDatabases());

$connection->close();
