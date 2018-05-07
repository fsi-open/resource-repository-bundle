<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceCKEditorPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceFSiFilePass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\FSIResourceRepositoryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FSiResourceRepositoryBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        if ($container->hasExtension('fsi_doctrine_extensions')) {
            $container->addCompilerPass(new ResourceFSiFilePass());
        }

        if ($container->hasExtension('fos_ck_editor')) {
            $container->addCompilerPass(new ResourceCKEditorPass());
        }

        $container->addCompilerPass(new TwigFormPass());
        $container->addCompilerPass(new ResourcePass());
        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver(
                $this->getDoctrineMappings(),
                ['doctrine.orm.entity_manager']
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new FSIResourceRepositoryExtension();
        }

        return $this->extension;
    }

    /**
     * @return array
     */
    private function getDoctrineMappings()
    {
        return [
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'FSi\Bundle\ResourceRepositoryBundle\Model',
        ];
    }
}
