<?php

namespace Ns3777k\DoctrineDbalYoutube;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Exception;
use Ns3777k\DoctrineDbalYoutube\DBAL\Types\SuperInetType;
use Ns3777k\DoctrineDbalYoutube\DBAL\Types\Types as CustomTypes;
use Ns3777k\DoctrineDbalYoutube\VO\IpBlock;

class Bootstrap
{
    public static function init(Connection $connection): void
    {
        self::createTypes($connection);
        self::createTables($connection);
    }

    public static function loadNetworkFixtures(Connection $connection): void
    {
        foreach (range(1, 3) as $value) {
            $connection->insert(
                'network',
                ['title' => 'MSK-ADR-' . $value, 'range' => new IpBlock('192.168.' . $value . '2.1/24')],
                ['range' => CustomTypes::SUPER_INET->value],
            );
        }
    }

    private static function createTables(Connection $connection): void
    {
        $networkTable = new Table('network');
        $networkTable->addColumn('id', Types::INTEGER, ['notnull' => true, 'autoincrement' => true]);
        $networkTable->addColumn('title', Types::STRING, ['notnull' => true, 'length' => 255]);
        $networkTable->addColumn('range', CustomTypes::SUPER_INET->value, ['notnull' => true]);
        $networkTable->setPrimaryKey(['id']);

        $sm = $connection->createSchemaManager();

        try {
            $sm->createTable($networkTable);
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
        }
    }

    private static function createTypes(Connection $connection): void
    {
        Type::addType(CustomTypes::SUPER_INET->value, SuperInetType::class);

        $connection->getDatabasePlatform()
            ->registerDoctrineTypeMapping(CustomTypes::PG_SUPER_INET->value, CustomTypes::SUPER_INET->value);
    }
}
