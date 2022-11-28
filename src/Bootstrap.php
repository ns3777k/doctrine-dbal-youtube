<?php

namespace Ns3777k\DoctrineDbalYoutube;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Exception;

class Bootstrap
{
    public static function init(Connection $connection): void
    {
        self::createTables($connection);
    }

    private static function createTables(Connection $connection): void
    {
        $clientsTable = new Table('clients');
        $clientsTable->addColumn('id', Types::INTEGER, ['notnull' => true, 'autoincrement' => true]);
        $clientsTable->addColumn('name', Types::STRING, ['notnull' => true, 'length' => 255]);

        $employeesTable = new Table('employees');
        $employeesTable->addColumn('id', Types::INTEGER, ['notnull' => true, 'autoincrement' => true]);
        $employeesTable->addColumn('name', Types::STRING, ['notnull' => true, 'length' => 255]);

        $sm = $connection->createSchemaManager();

        try {
            $sm->createTable($clientsTable);
            $sm->createTable($employeesTable);
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
        }
    }
}
