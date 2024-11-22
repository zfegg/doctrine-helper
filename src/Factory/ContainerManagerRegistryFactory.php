<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper\Factory;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerManagerRegistry;

class ContainerManagerRegistryFactory
{

    public function __invoke(ContainerInterface $container): ContainerManagerRegistry
    {
        $doctrineConfig = $container->get('config')['doctrine'] ?? [];

        if (empty($doctrineConfig['connection']) || empty($doctrineConfig['entity_manager'])) {
            throw new class('Empty doctrine config.')
                extends \RuntimeException
                implements ContainerExceptionInterface {
            };
        }

        $connections = $entityManagers = [];

        foreach ($doctrineConfig['connection'] as $name => $config) {
            $connections[$name] = 'doctrine.connection.' . $name;
        }

        foreach ($doctrineConfig['entity_manager'] as $name => $config) {
            $entityManagers[$name] = 'doctrine.entity_manager.' . $name;
        }

        return new ContainerManagerRegistry($container, $connections, $entityManagers, 'default', 'default');
    }
}
