<?php

namespace Zfegg\DoctrineHelper;

use Doctrine\ORM\Mapping\EntityListenerResolver;
use Psr\Container\ContainerInterface;

class ContainerEntityListenerResolver implements EntityListenerResolver
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function resolve($className)
    {
        return $this->container->get($className);
    }

    function clear($className = null)
    {
        throw new \RuntimeException('Use container instead.');
    }

    function register($object)
    {
        throw new \RuntimeException('Use container instead.');
    }
}
