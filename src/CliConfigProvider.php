<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper;

use Doctrine\DBAL\Tools\Console as DBALConsole;
use Doctrine\ORM\Tools\Console\Command as ORMCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;

class CliConfigProvider
{

    public function __invoke(): array
    {
        $dbalCommands = [
            // DBAL Commands
            DBALConsole\Command\RunSqlCommand::class,
        ];

        $commands = [
            // ORM Commands
            ORMCommand\ClearCache\CollectionRegionCommand::class,
            ORMCommand\ClearCache\EntityRegionCommand::class,
            ORMCommand\ClearCache\MetadataCommand::class,
            ORMCommand\ClearCache\QueryCommand::class,
            ORMCommand\ClearCache\QueryRegionCommand::class,
            ORMCommand\ClearCache\ResultCommand::class,
            ORMCommand\SchemaTool\CreateCommand::class,
            ORMCommand\SchemaTool\UpdateCommand::class,
            ORMCommand\SchemaTool\DropCommand::class,
            ORMCommand\GenerateProxiesCommand::class,
            ORMCommand\RunDqlCommand::class,
            ORMCommand\ValidateSchemaCommand::class,
            ORMCommand\InfoCommand::class,
            ORMCommand\MappingDescribeCommand::class,
        ];

        $dbalCommandFactories = array_fill_keys(
            $dbalCommands,
            [Factory\AbstractInjectFactory::class, DBALConsole\ConnectionProvider::class],
        );

        $commandFactories = array_fill_keys(
            $commands,
            [Factory\AbstractInjectFactory::class, EntityManagerProvider::class],
        );

        return [

            'commands' => [
                ...$dbalCommands,
                ...$commands,
            ],

            'dependencies' => [
                'factories' => $commandFactories + $dbalCommandFactories,
            ],
        ];
    }
}
