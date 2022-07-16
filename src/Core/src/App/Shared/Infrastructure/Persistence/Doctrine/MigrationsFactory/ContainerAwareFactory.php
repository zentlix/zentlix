<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Infrastructure\Persistence\Doctrine\MigrationsFactory;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Version\MigrationFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ContainerAwareFactory implements MigrationFactory
{
    private ?ContainerInterface $container;

    public function __construct(
        private readonly Connection $connection,
        private readonly LoggerInterface $logger,
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public function createVersion(string $migrationClassName): AbstractMigration
    {
        $instance = new $migrationClassName(
            $this->connection,
            $this->logger
        );

        if ($instance instanceof ContainerAwareInterface) {
            $instance->setContainer($this->container);
        }

        /** @psalm-suppress LessSpecificReturnStatement */
        return $instance;
    }
}
