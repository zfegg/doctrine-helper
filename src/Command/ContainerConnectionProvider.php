<?php

namespace Zfegg\DoctrineHelper\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\Persistence\ManagerRegistry;

class ContainerConnectionProvider implements ConnectionProvider
{
    private ManagerRegistry $registry;


    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultConnection(): Connection
    {
        return $this->registry->getConnection();
    }

    /**
     * @inheritDoc
     */
    public function getConnection(string $name): Connection
    {
        return $this->registry->getConnection($name);
    }
}
