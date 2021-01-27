<?php

namespace ZfeggTest\DoctrineHelper;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerConnectionProvider;
use PHPUnit\Framework\TestCase;

class ContainerConnectionProviderTest extends TestCase
{

    public function testGetConnection()
    {
        $connections = [
            'doctrine.connection.default' => DriverManager::getConnection(['url' => 'sqlite::memory:']),
            'doctrine.connection.test' => DriverManager::getConnection(['url' => 'sqlite::memory:']),
        ];

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturnCallback(function (string $name) use ($connections) {
            return $connections[$name];
        });

        $cp = new ContainerConnectionProvider($container);

        $this->assertEquals($connections['doctrine.connection.default'], $cp->getDefaultConnection());
        $this->assertEquals($connections['doctrine.connection.default'], $cp->getConnection('default'));
        $this->assertEquals($connections['doctrine.connection.test'], $cp->getConnection('test'));
    }
}
