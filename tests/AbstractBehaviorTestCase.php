<?php

declare(strict_types=1);

namespace Knp\DoctrineBehaviors\Tests;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Knp\DoctrineBehaviors\Tests\HttpKernel\DoctrineBehaviorsKernel;

abstract class AbstractBehaviorTestCase extends TestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    private ContainerInterface $container;

    protected function setUp(): void
    {
        $proxyDir = sys_get_temp_dir() . '/doctrine_behaviors_test/doctrine/orm/Proxies';
        if (!is_dir($proxyDir)) {
            mkdir($proxyDir, 0777, true);
        }

        $doctrineBehaviorsKernel = new DoctrineBehaviorsKernel($this->provideCustomConfigs());
        $doctrineBehaviorsKernel->boot();

        $this->container = $doctrineBehaviorsKernel->getContainer();

        $this->entityManager = $this->getService('doctrine.orm.entity_manager');
        $this->loadDatabaseFixtures();
    }

    protected function loadDatabaseFixtures(): void
    {
        /** @var DatabaseLoader $databaseLoader */
        $databaseLoader = $this->getService(DatabaseLoader::class);
        $databaseLoader->reload();
    }

    protected function isPostgreSql(): bool
    {
        /** @var Connection $connection */
        $connection = $this->entityManager->getConnection();

        return $connection->getDatabasePlatform() instanceof PostgreSQLPlatform;
    }

    /**
     * @return string[]
     */
    protected function provideCustomConfigs(): array
    {
        return [];
    }

    protected function createAndRegisterDebugStack(): DebugStack
    {
        $debugStack = new DebugStack();

        $this->entityManager->getConnection()
            ->getConfiguration()
            ->setSQLLogger($debugStack);

        return $debugStack;
    }

    /**
     * @template T as object
     * @param class-string<T> $type
     * @return T
     */
    protected function getService(string $type): object
    {
        return $this->container->get($type);
    }
}
