<?php

namespace Grossum\StaticPageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('grossum_static_page');

        $rootNode
            ->children()
                ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('static_page')
                            ->defaultValue('Application\\Grossum\\StaticPageBundle\\Entity\\StaticPage')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
