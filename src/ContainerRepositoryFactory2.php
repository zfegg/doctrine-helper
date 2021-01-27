<?php


namespace Zfegg\DoctrineHelper;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class ContainerRepositoryFactory2 implements RepositoryFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * The list of EntityRepository instances.
     *
     * @var \Doctrine\Common\Persistence\ObjectRepository[]
     */
    private $repositoryList = [];

    /**
     * @var array
     */
    private $config;
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var array
     */
    private $entitiesConfig = [];

    public function __construct(ContainerInterface $container, ManagerRegistry $registry, array $config)
    {
        $this->container = $container;
        $this->registry = $registry;
        $this->config = $config;

        foreach ($config as $repositoryName => $item) {
            $this->entitiesConfig[$item['entity']] = [
                'repository' => $repositoryName,
                'entity_manager' => $item['entity_manager'],
            ];
        }
    }

    /**
     * @inheritDoc
     */
    public function getRepository(EntityManagerInterface $entityManager, $entityName)
    {
        $repositoryHash = $entityManager->getClassMetadata($entityName)->getName() . spl_object_hash($entityManager);

        if (isset($this->repositoryList[$repositoryHash])) {
            return $this->repositoryList[$repositoryHash];
        }

        return $this->repositoryList[$repositoryHash] = $this->createRepository($entityManager, $entityName);
    }

    public function create(string $repositoryClassName)
    {
        $config = $this->config[$repositoryClassName];
        $entityManager = $this->registry->getManager($config['entity_manager'] ?? null);

        /* @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata = $entityManager->getClassMetadata($config['entity']);

        if (! $metadata->customRepositoryClassName) {
            $metadata->setCustomRepositoryClass($repositoryClassName);
        } else {
            throw new \RuntimeException('Conflict repository config');
        }

        $this->getRepository($entityManager, $config['entity']);
    }

    public function has(string $repositoryClassName)
    {
        return isset($this->config[$repositoryClassName]);
    }

    private function createRepository(EntityManagerInterface $entityManager, $entityName)
    {
        /* @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata            = $entityManager->getClassMetadata($entityName);
        if (isset($this->entitiesConfig[$entityName])) {
            $config = $this->entitiesConfig[$entityName];
            $repositoryClassName = $config['repository'];

            if ($metadata->customRepositoryClassName && $metadata->customRepositoryClassName != $repositoryClassName) {
                throw new \RuntimeException('Repository config conflict with metadata.');
            }
        } elseif ($metadata->customRepositoryClassName) {
            $repositoryClassName = $metadata->customRepositoryClassName;
        } else {
            $repositoryClassName = $entityManager->getConfiguration()->getDefaultRepositoryClassName();
        }

        $container = $this->container;

        //Reflection factory.
        $ref = new ReflectionClass($repositoryClassName);
        $params = $ref->getConstructor()->getParameters();

        $args = [];
        foreach ($params as $param) {
            $paramClass = $param->getClass();
            if (is_subclass_of($paramClass, EntityManagerInterface::class)) {
                $args[] = $entityManager;
            } elseif ($paramClass == ClassMetadata::class) {
                $args[] = $entityManager->getClassMetadata($entityName);
            } elseif ($paramClass && $container->has($paramClass)) {
                $args[] = $container->get($paramClass);
            } elseif ($param->isOptional()) {
                $args[] = $param->getDefaultValue();
            } else {
                throw new class(
                    sprintf('Create "%s" failed, can not create param $%s.', $repositoryClassName, $param->getName())
                )
                    extends \RuntimeException
                    implements ContainerExceptionInterface {};
            }
        }

        return $ref->newInstanceArgs($args);
    }
}
