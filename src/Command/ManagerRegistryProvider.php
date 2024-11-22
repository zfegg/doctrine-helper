<?php

declare(strict_types = 1);

namespace Zfegg\DoctrineHelper\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\Persistence\ManagerRegistry;

class ManagerRegistryProvider implements EntityManagerProvider
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function getDefaultManager(): EntityManagerInterface
    {
        return $this->registry->getManager();
    }

    public function getManager(string $name): EntityManagerInterface
    {
        return $this->registry->getManager($name);
    }
}
