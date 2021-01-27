<?php

namespace Zfegg\DoctrineHelper;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Psr\Container\ContainerInterface;

class ContainerConnectionProvider implements ConnectionProvider
{
    private ContainerInterface $container;
    private string $default;

    public function __construct(ContainerInterface $container, string $default = 'default')
    {
        $this->container = $container;
        $this->default = $default;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultConnection(): Connection
    {
        return $this->container->get('doctrine.connection.' . $this->default);
    }

    /**
     * @inheritDoc
     */
    public function getConnection(string $name): Connection
    {
        return $this->container->get('doctrine.connection.' . $name);
    }
}
