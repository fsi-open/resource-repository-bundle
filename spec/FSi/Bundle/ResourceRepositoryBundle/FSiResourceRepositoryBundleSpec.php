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

    function it_add_complier_pass_during_build(ContainerBuilder $container)
    {
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass'))
            ->shouldBeCalled();
        $container->addCompilerPass(Argument::type('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass'))
            ->shouldBeCalled();


        $this->build($container);
    }
}
