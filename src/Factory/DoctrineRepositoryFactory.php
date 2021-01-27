<?php


namespace Zfegg\DoctrineHelper\Factory;


use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerRepositoryFactory;

class DoctrineRepositoryFactory
{

    public static function __callStatic(string $entityName, array $arguments)
    {
        /** @var ContainerInterface $container */
        $container = $arguments[0];

        $em = $container->get(EntityManagerInterface::class);
        return $container->get(ContainerRepositoryFactory::class)->getOrCreateRepository(
            $em,
            $em->getClassMetadata($entityName),
        );
    }
}
