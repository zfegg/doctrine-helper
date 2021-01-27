<?php

namespace Zfegg\DoctrineHelper\Factory;

use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\Command\ProxyDoctrineCommand;

class ProxyDoctrineCommandFactory
{
    public function __invoke(ContainerInterface $container, string $requestName)
    {
        return new ProxyDoctrineCommand(
            $container->get(ManagerRegistry::class),
            new $requestName()
        );
    }
}
