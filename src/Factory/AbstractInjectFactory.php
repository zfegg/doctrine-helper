<?php


namespace Zfegg\DoctrineHelper\Factory;


use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;

class AbstractInjectFactory
{
    public static function __callStatic($name, $arguments)
    {
        $container = $arguments[0];
        $className = $arguments[1];

        return new $className($container->get($name));
    }
}