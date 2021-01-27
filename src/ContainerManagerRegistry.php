<?php


namespace Zfegg\DoctrineHelper;

use Doctrine\ORM\ORMException;
use Doctrine\Persistence\AbstractManagerRegistry;
use Doctrine\Persistence\Proxy;
use Psr\Container\ContainerInterface;

class ContainerManagerRegistry extends AbstractManagerRegistry
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ContainerInterface $container,
        array $connections,
        array $entityManagers,
        $defaultConnection,
        $defaultEntityManager
    ) {
        $this->container = $container;
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
    protected function getService($name)
    {
        return $this->container->get($name);
    }

    /**
     * @inheritDoc
     */
    protected function resetService($name)
    {
    }

    /**
     * @inheritDoc
     */
    public function getAliasNamespace($alias)
    {
        foreach (array_keys($this->getManagers()) as $name) {
            try {
                return $this->getManager($name)->getConfiguration()->getEntityNamespace($alias);
            } catch (ORMException $e) {
            }
        }

        throw ORMException::unknownEntityNamespace($alias);
    }
}
