<?php

namespace Zfegg\DoctrineHelper\Command\Proxy;

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\Persistence\ManagerRegistry;

trait InjectRegistryTrait
{
    /** @var ManagerRegistry */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine, string $name = null)
    {
        parent::__construct($name);

        $this->doctrine = $doctrine;
    }

    /**
     * Convenience method to push the helper sets of a given entity manager into the application.
     *
     * @param string $emName
     */
    private function addEntityManagerHelper(string $emName)
    {
        $em = $this->doctrine->getManager($emName);

        $helperSet = $this->getHelperSet();
        $helperSet->set(new ConnectionHelper($em->getConnection()), 'db');
        $helperSet->set(new EntityManagerHelper($em), 'em');
    }

    /**
     * Convenience method to push the helper sets of a given connection into the application.
     *
     * @param string $connName
     */
    private function addConnectionHelper(string $connName)
    {
        $connection = $this->doctrine->getConnection($connName);
        $helperSet  = $this->getHelperSet();
        $helperSet->set(new ConnectionHelper($connection), 'db');
    }
}
