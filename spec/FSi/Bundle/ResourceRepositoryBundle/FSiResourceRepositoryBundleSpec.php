<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceCKEditorPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceFSiFilePass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass;
use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\FSIResourceRepositoryExtension;
use FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FSiResourceRepositoryBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FSiResourceRepositoryBundle::class);
    }

    function it_is_bundle()
    {
        $this->shouldBeAnInstanceOf(Bundle::class);
    }

    function it_have_fsi_resource_repository_extension()
    {
        $this->getContainerExtension()->shouldReturnAnInstanceOf(FSIResourceRepositoryExtension::class);
    }

    function it_add_compiler_pass_during_build(ContainerBuilder $container)
    {
        $container->hasExtension('fsi_doctrine_extensions')->shouldBeCalled()->willReturn(true);
        $container->hasExtension('fos_ck_editor')->shouldBeCalled()->willReturn(true);
        $container->addCompilerPass(Argument::type(ResourceFSiFilePass::class))->shouldBeCalled();
        $container->addCompilerPass(Argument::type(ResourceCKEditorPass::class))->shouldBeCalled();
        $container->addCompilerPass(Argument::type(TwigFormPass::class))->shouldBeCalled();
        $container->addCompilerPass(Argument::type(ResourcePass::class))->shouldBeCalled();
        $container->addCompilerPass(Argument::type(DoctrineOrmMappingsPass::class))->shouldBeCalled();

        $this->build($container);
    }
}
