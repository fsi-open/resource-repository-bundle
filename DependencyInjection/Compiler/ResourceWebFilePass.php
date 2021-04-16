<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\WebFileType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ResourceWebFilePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $fileTypeDefinition = new Definition(WebFileType::class);
        $fileTypeDefinition->addTag('resource.type', ['alias' => 'web_file']);
        $container->setDefinition(
            'fsi_resource_repository.resource.type.web_file',
            $fileTypeDefinition
        );
    }
}
