<?php

namespace Deveosys\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('deveosys_admin');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('login')
                    ->children()
                        ->scalarNode('title')
                            ->defaultValue('Deveosys')
                            ->info('The name displayed in the login section.')
                        ->end()
                        ->arrayNode('logo')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('path')
                                    ->defaultValue('bundles/deveosysadmin/images/logo-green.png')
                                    ->info('The name displayed in the login section.')
                                ->end()
                                ->integerNode('size')
                                    ->defaultValue(100)
                                    ->info('The image with in pixels.')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end() // login
            ->end()
        ;

        return $treeBuilder;
    }
}
