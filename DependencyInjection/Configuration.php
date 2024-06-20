<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private const SUPPORTED_DRIVERS = ['orm'];

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('fsi_resource_repository');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->scalarNode('db_driver')
                ->defaultValue('orm')
                ->validate()
                    ->ifNotInArray(self::SUPPORTED_DRIVERS)
                    ->thenInvalid(
                        'The driver %s is not supported. Please choose one of '
                        . implode(', ', self::SUPPORTED_DRIVERS)
                    )
                ->end()
                ->cannotBeOverwritten()
                ->cannotBeEmpty()
            ->end()
            ->scalarNode('map_path')->defaultValue('%kernel.project_dir%/config/resource_map.yml')->end()
            ->scalarNode('resource_class')->isRequired()->cannotBeEmpty()->end();

        return $treeBuilder;
    }
}
