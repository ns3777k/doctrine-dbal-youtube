<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Ns3777k\DoctrineDbalYoutube\Bootstrap;
use Ns3777k\DoctrineDbalYoutube\MyLogger;

require_once __DIR__ . '/vendor/autoload.php';

$config = (new Configuration())->setMiddlewares([new Middleware(new MyLogger())]);
$config->setSchemaAssetsFilter(fn (string $asset) => !str_starts_with($asset, 'clients'));
$connection = DriverManager::getConnection(
    ['url' => 'postgres://postgres:12345@127.0.0.1:5432/postgres?sslmode=disable&charset=utf8'],
    $config
);

Bootstrap::init($connection);

var_dump($connection->createSchemaManager()->listTableNames());
