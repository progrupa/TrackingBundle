<?php

namespace Progrupa\TrackingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('progrupa_tracking')
            ->children()
                ->arrayNode('site_key')->isRequired(true)->prototype('scalar')->end()->end()
                ->arrayNode('api_key')->isRequired(true)->prototype('scalar')->end()->end()
                ->arrayNode('endpoint')->isRequired(true)->defaultValue('https://modelsdownload.com/pl/api/')->prototype('scalar')->end()->end()
            ->end();

        return $treeBuilder;
    }
}
