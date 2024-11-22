<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper;

use Doctrine\Persistence\AbstractManagerRegistry;
use Doctrine\Persistence\Proxy;
use Psr\Container\ContainerInterface;

class ContainerManagerRegistry extends AbstractManagerRegistry
{
    public function __construct(
        private ContainerInterface $container,
        array $connections,
        array $entityManagers,
        string $defaultConnection,
        string $defaultEntityManager
    ) {
        parent::__construct(
            'ORM',
            $connections,
            $entityManagers,
            $defaultConnection,
            $defaultEntityManager,
            Proxy::class
        );
    }

    /**
     * @inheritDoc
     */
    protected function getService(string $name)
    {
        return $this->container->get($name);
    }

    /**
     * @inheritDoc
     */
    protected function resetService(string $name)
    {
    }
}
