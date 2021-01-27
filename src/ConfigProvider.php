<?php


namespace Zfegg\DoctrineHelper;

use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ManagerRegistry;

class ConfigProvider
{

    public function __invoke()
    {
        return [
            'dependencies' => [
                'abstract_factories' => [
                    Factory\DoctrineAbstractFactory::class,
//                    Factory\DoctrineRepositoryAbstractFactory::class,
                ],
                'factories' => [
                    ContainerConnectionProvider::class => Factory\ContainerConnectionProviderFactory::class,
                    ContainerManagerRegistry::class => Factory\ContainerManagerRegistryFactory::class,
                    ContainerRepositoryFactory::class => Factory\ContainerRepositoryFactoryFactory::class,
                ],
                'aliases' => [
                    ManagerRegistry::class => ContainerManagerRegistry::class,
                    ConnectionProvider::class => ContainerConnectionProvider::class,
                    RepositoryFactory::class => ContainerRepositoryFactory::class,

                    EntityManagerInterface::class => 'doctrine.entity_manager.default',
                    EntityManager::class => 'doctrine.entity_manager.default',
                ],
            ],
        ];
    }
}
