<?php

namespace Apb\MailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('mailer_bundle');

        $treeBuilder
            ->getRootNode()
            ->children()
            ->arrayNode('configuration')
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('apiUrl')->defaultValue('https://your-project')->end()
                    ->scalarNode('projectName')->defaultValue('My project')->end()
                    ->scalarNode('sender')->defaultValue('example@url.com')->end()
                    ->scalarNode('senderStr')->defaultValue('John Doe')->end()
                    ->scalarNode('style')->end()
                    ->scalarNode('logo')->defaultValue('logo.png')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}