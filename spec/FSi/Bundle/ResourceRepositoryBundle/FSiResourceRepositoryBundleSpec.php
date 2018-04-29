<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FSiResourceRepositoryBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle');
    }

    function it_is_bundle()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\HttpKernel\Bundle\Bundle');
    }

    function it_have_fsi_resource_repository_extension()
    {
        $this->getContainerExtension()->shouldReturnAnInstanceOf('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\FSIResourceRepositoryExtension');
    }

    function it_add_compiler_pass_during_build(ContainerBuilder $container)
    {
        $container->hasExtension('fsi_doctrine_extensions')->shouldBeCalled()->willReturn(true);
        $container->hasExtension('fsi_form_extensions')->shouldBeCalled()->willReturn(true);
        $container->hasExtension('fos_ck_editor')->shouldBeCalled()->willReturn(true);
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceFSiFilePass'))
            ->shouldBeCalled();
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceCKEditorPass'))
            ->shouldBeCalled();
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourceFSiCKEditorPass'))
            ->shouldBeCalled();
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass'))
            ->shouldBeCalled();
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass'))
            ->shouldBeCalled();

        $container->addCompilerPass(Argument::type('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass'))
            ->shouldBeCalled();

        $this->build($container);
    }
}
