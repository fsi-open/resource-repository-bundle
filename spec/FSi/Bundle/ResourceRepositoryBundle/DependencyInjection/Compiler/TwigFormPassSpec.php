<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler;

use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\TwigFormPass;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TwigFormPass::class);
    }

    function it_is_complier_pass()
    {
        $this->shouldBeAnInstanceOf(CompilerPassInterface::class);
    }

    function it_should_add_resource_path_during_process_method(ContainerBuilder $container)
    {
        $container->hasParameter('twig.form.resources')->shouldBeCalled()->willReturn(true);

        $container->getParameter('twig.form.resources')->willReturn([]);
        $container->setParameter(
            'twig.form.resources',
            ['@FSiResourceRepository/Form/form_div_layout.html.twig']
        )->shouldBeCalled();

        $this->process($container);
    }
}
