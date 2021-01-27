<?php

namespace Zfegg\DoctrineHelper\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerRepositoryFactory;

class DoctrineRepositoryAbstractFactory implements AbstractFactoryInterface
{
    /** @var object[][]  */
    private array $repositories = [];

    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        if (! $this->repositories) {
            $em = $container->get(EntityManagerInterface::class);

            /** @var \Doctrine\ORM\Mapping\ClassMetadataInfo[] $classMetas */
            $classMetas = $em->getMetadataFactory()->getAllMetadata();

            foreach ($classMetas as $classMeta) {
                if ($classMeta->customRepositoryClassName) {
                    $this->repositories[$classMeta->customRepositoryClassName] = [$em, $classMeta];
                }
            }
        }

        return isset($this->repositories[$requestedName]);
    }

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $container->get(ContainerRepositoryFactory::class)
            ->getOrCreateRepository(...$this->repositories[$requestedName]);
    }
}
