<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle;

use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\FSIResourceRepositoryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FSiResourceRepositoryBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TwigFormPass());
        $container->addCompilerPass(new ResourcePass());
    }


    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new FSIResourceRepositoryExtension();
        }

        return $this->extension;
    }
}
