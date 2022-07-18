<?php

declare(strict_types=1);

namespace Zentlix\Users\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class UsersExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__, 2).'/config'));

        $loader->load('bus.php');
        $loader->load('commands.php');
        $loader->load('controllers.php');
        $loader->load('services.php');
        $loader->load('repositories.php');
        $loader->load('projections.php');
        $loader->load('specifications.php');

        switch ($container->getParameter('read_engine')) {
            default:
                $loader->load('doctrine_repositories.php');
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(\dirname(__DIR__, 2).'/config'));

        $loader->load('doctrine.xml');
    }
}
