<?php


namespace Zfegg\DoctrineHelper;

use Doctrine\DBAL\Tools\Console as DBALConsole;
use Doctrine\ORM\Tools\Console\Command as ORMCommand;
use Zfegg\DoctrineHelper\Command\CreateDatabaseDoctrineCommand;
use Zfegg\DoctrineHelper\Command\DropDatabaseDoctrineCommand;
use Zfegg\DoctrineHelper\Command\ImportMappingDoctrineCommand;

class CliConfigProvider
{

    public function __invoke()
    {

        $commands = [
            // DBAL Commands
            DBALConsole\Command\ReservedWordsCommand::class,
            DBALConsole\Command\RunSqlCommand::class,

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
            ORMCommand\EnsureProductionSettingsCommand::class,
            ORMCommand\GenerateRepositoriesCommand::class,
            ORMCommand\GenerateEntitiesCommand::class,
            ORMCommand\GenerateProxiesCommand::class,
            ORMCommand\ConvertMappingCommand::class,
            ORMCommand\RunDqlCommand::class,
            ORMCommand\ValidateSchemaCommand::class,
            ORMCommand\InfoCommand::class,
            ORMCommand\MappingDescribeCommand::class,
        ];

        $commandFactories = array_fill_keys($commands, Factory\ProxyDoctrineCommandFactory::class);

        return [

            'commands' => [
                ...$commands,
                CreateDatabaseDoctrineCommand::class,
                DropDatabaseDoctrineCommand::class,
                ImportMappingDoctrineCommand::class,
            ],

            'dependencies' => [
                'factories' => $commandFactories,
            ],
        ];
    }
}