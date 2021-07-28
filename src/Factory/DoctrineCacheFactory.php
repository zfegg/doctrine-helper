<?php

namespace Zfegg\DoctrineHelper\Factory;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Psr\Container\ContainerInterface;

class DoctrineCacheFactory
{
    private string $key;

    public function __construct(string $key = 'cache.default')
    {
        $this->key = $key;
    }

    public static function __callStatic($name, $arguments)
    {
        return (new self($name))($arguments[0]);
    }

    public function __invoke(ContainerInterface $container): Cache
    {
        return DoctrineProvider::wrap($container->get($this->key));
    }
}