<?php


namespace Zfegg\DoctrineHelper\Factory;


use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerConnectionProvider;

class ContainerConnectionProviderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ContainerConnectionProvider($container);
    }
}