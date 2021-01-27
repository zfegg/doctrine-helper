<?php


namespace Zfegg\DoctrineHelper\Factory;

use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerRepositoryFactory;

class ContainerRepositoryFactoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ContainerRepositoryFactory($container);
    }
}
