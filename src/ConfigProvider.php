<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper;

use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\Persistence\ManagerRegistry;

class ConfigProvider
{

    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'abstract_factories' => [
                    Factory\DoctrineAbstractFactory::class,
                ],
                'factories' => [
                    Command\ContainerConnectionProvider::class =>
                        [Factory\AbstractInjectFactory::class, ManagerRegistry::class],
                    Command\ManagerRegistryProvider::class =>
                        [Factory\AbstractInjectFactory::class, ManagerRegistry::class],
                    ContainerManagerRegistry::class => Factory\ContainerManagerRegistryFactory::class,
                ],
                'aliases' => [
                    ManagerRegistry::class => ContainerManagerRegistry::class,
                    ConnectionProvider::class => Command\ContainerConnectionProvider::class,
                    EntityManagerProvider::class => Command\ManagerRegistryProvider::class,
                    RepositoryFactory::class => ContainerRepositoryFactory::class,

                    EntityManagerInterface::class => 'doctrine.entity_manager.default',
                    EntityManager::class => 'doctrine.entity_manager.default',
                ],
            ],
        ];
    }
}
