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
            ->children()
                ->arrayNode('login')
                    ->children()
                        ->scalarNode('title')
                            ->defaultValue('Deveosys')
                            ->info('The name displayed in the login section.')
                        ->end()
                        ->scalarNode('logo')
                            ->defaultValue('bundles/deveosysadmin/images/logo.png')
                            ->info('Image displayed in the login section.')
                        ->end()
                    ->end()
                ->end() // login
            ->end()
        ;

        return $treeBuilder;
    }
}
