<?php

namespace Positibe\Bundle\CmfRoutingExtraBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('positibe_cmf_routing_extra');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->scalarNode('name_filter_regex')->defaultValue(null)->end()
                ->arrayNode('templates')
                    ->useAttributeAsKey('class')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('controllers')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->arrayNode('_controller')
                        ->prototype('variable')->end()
                    ->end()

            ->end();
        return $treeBuilder;
    }
}
