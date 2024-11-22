<?php

namespace ZfeggTest\DoctrineHelper;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Psr\Container\ContainerInterface;
use Zfegg\DoctrineHelper\ContainerConnectionProvider;
use PHPUnit\Framework\TestCase;

class ContainerConnectionProviderTest extends TestCase
{

    public function testGetConnection()
    {
        $dsnParser = new DsnParser(['sqlite' => 'pdo_sqlite']);
        $params = $dsnParser->parse( 'sqlite::memory:');
        $connections = [
            'doctrine.connection.default' => DriverManager::getConnection($params),
            'doctrine.connection.test' => DriverManager::getConnection($params),
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
