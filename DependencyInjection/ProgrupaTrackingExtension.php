<?php

namespace Progrupa\TrackingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ProgrupaTrackingExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('progrupa.tracking.site_key', $config['site_key']);
        $container->setParameter('progrupa.tracking.api_key', $config['api_key']);
        $container->setParameter('progrupa.tracking.endpoint', $config['endpoint']);
        $container->setParameter('progrupa.tracking.api_endpoint', $config['endpoint'] . 'api/');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
