<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass');
    }

    function it_is_complier_pass()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_should_add_resource_path_during_process_method(ContainerBuilder $container)
    {
        $container->hasParameter('twig.form.resources')->shouldBeCalled()->willReturn(true);

        $container->getParameter('twig.form.resources')->willReturn([]);
        $container->setParameter('twig.form.resources', ['@FSiResourceRepository/Form/form_div_layout.html.twig'])
            ->shouldBeCalled();

        $this->process($container);
    }
}
