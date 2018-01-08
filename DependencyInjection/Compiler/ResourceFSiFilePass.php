<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\FSiFileType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\FSiImageType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\FSiRemovableFileType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;

class ResourceFSiFilePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = new Definition(FSiFileType::class);
        $definition->addTag('resource.type', ['alias' => 'fsi_file']);
        $container->setDefinition('fsi_resource_repository.resource.type.fsi_file', $definition);

        $definition = new Definition(FSiImageType::class);
        $definition->addTag('resource.type', ['alias' => 'fsi_image']);
        $container->setDefinition('fsi_resource_repository.resource.type.fsi_image', $definition);

        $definition = new Definition(FSiRemovableFileType::class);
        $definition->addTag('resource.type', ['alias' => 'fsi_removable_file']);
        $container->setDefinition('fsi_resource_repository.resource.type.fsi_removable_file', $definition);
    }
}
