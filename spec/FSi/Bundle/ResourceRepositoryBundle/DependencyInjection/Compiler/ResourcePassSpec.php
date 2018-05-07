<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler;

use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ResourcePassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ResourcePass::class);
    }

    function it_is_complier_pass()
    {
        $this->shouldBeAnInstanceOf(CompilerPassInterface::class);
    }

    function it_should_replace_resource_types_parameters_with_array_of_resources(
        ContainerBuilder $container,
        Definition $resourceDefinition
    ) {
        $container->findTaggedServiceIds('resource.type')->shouldBeCalled()->willReturn([
            'fsi_resource_repository.resource.type.text' => [['alias' => 'text']]
        ]);

        $container->getDefinition('fsi_resource_repository.resource.type.text')->willReturn($resourceDefinition);
        $resourceDefinition->getClass()->shouldBeCalled()->willReturn(TexType::class);

        $container->setParameter('fsi_resource_repository.resource.types', [
            'text' => TexType::class
        ])->shouldBeCalled();

        $this->process($container);
    }
}
