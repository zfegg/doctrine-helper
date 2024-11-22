<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper;

use Doctrine\ORM\Mapping\EntityListenerResolver;
use Psr\Container\ContainerInterface;

class ContainerEntityListenerResolver implements EntityListenerResolver
{

    public function __construct(
        private ContainerInterface $container
    ) {
    }

    /**
     * @inheritDoc
     */
    public function resolve(string $className): object
    {
        return $this->container->get($className);
    }

    /**
     * @inheritdoc
     */
    public function clear(string|null $className = null): void
    {
        throw new \RuntimeException('Use container instead.');
    }

    /**
     * @inheritdoc
     */
    public function register(object $object): void
    {
        throw new \RuntimeException('Use container instead.');
    }
}
