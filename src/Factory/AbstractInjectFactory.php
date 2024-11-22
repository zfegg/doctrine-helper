<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper\Factory;

class AbstractInjectFactory
{
    public static function __callStatic(string $name, array $arguments): object
    {
        $container = $arguments[0];
        $className = $arguments[1];

        return new $className($container->get($name));
    }
}
