<?php


namespace Zfegg\DoctrineHelper\Factory;


use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Roave\PsrContainerDoctrine\CacheFactory;
use Roave\PsrContainerDoctrine\ConfigurationFactory;
use Roave\PsrContainerDoctrine\ConnectionFactory;
use Roave\PsrContainerDoctrine\DriverFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;
use Roave\PsrContainerDoctrine\EventManagerFactory;
use Roave\PsrContainerDoctrine\MigrationsConfigurationFactory;

class DoctrineAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (strpos($requestedName, 'doctrine.') !== 0) {
            return false;
        }
        [, $service, $name] = explode('.', $requestedName);
        return isset($container->get('config')['doctrine'][$service][$name]);
    }


    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        [, $service, $name] = explode('.', $requestedName);
        $factoryMap = [
            'entity_manager' => EntityManagerFactory::class,
            'cache' => CacheFactory::class,
            'connection' => ConnectionFactory::class,
            'configuration' => ConfigurationFactory::class,
            'driver' => DriverFactory::class,
            'event_manager' => EventManagerFactory::class,
            'migrations' => MigrationsConfigurationFactory::class,
        ];
        return call_user_func([$factoryMap[$service], $name], $container);
    }
}