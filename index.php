<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Ns3777k\DoctrineDbalYoutube\Bootstrap;
use Ns3777k\DoctrineDbalYoutube\DBAL\Types\Types;
use Ns3777k\DoctrineDbalYoutube\MyLogger;
use Ns3777k\DoctrineDbalYoutube\VO\IpBlock;

require_once __DIR__ . '/vendor/autoload.php';

$config = (new Configuration())->setMiddlewares([new Middleware(new MyLogger())]);
$config->setSchemaAssetsFilter(fn (string $asset) => !str_starts_with($asset, 'clients'));
$connection = DriverManager::getConnection(
    ['url' => 'postgres://postgres:12345@127.0.0.1:5432/postgres?sslmode=disable&charset=utf8'],
    $config
);

Bootstrap::init($connection);

//var_dump($connection->insert(
//    'network',
//    ['title' => 'MSK-ADR-1', 'range' => new IpBlock('192.168.0.1/24')],
//    ['range' => Types::SUPER_INET->value],
//));

var_dump($connection->createSchemaManager()->listTableColumns('network'));

//$block = new IpBlock('192.168.0.1/24');
//$r = $connection->executeQuery(
//        'SELECT * FROM network WHERE range = :range',
//        ['range' => $block],
//        ['range' => Types::SUPER_INET->value],
//    )
//    ->fetchAssociative();
//var_dump($r);
//var_dump($connection->convertToPHPValue($r['range'], Types::SUPER_INET->value));
