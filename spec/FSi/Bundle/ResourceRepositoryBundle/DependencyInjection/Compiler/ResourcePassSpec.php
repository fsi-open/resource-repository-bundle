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
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ResourcePassSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourcePass::class);
    }

    public function it_is_complier_pass(): void
    {
        $this->shouldBeAnInstanceOf(CompilerPassInterface::class);
    }

    public function it_should_replace_resource_types_parameters_with_array_of_resources(
        ContainerBuilder $container,
        Definition $resourceDefinition
    ): void {
        $container->findTaggedServiceIds('resource.type')->shouldBeCalled()->willReturn([
            'fsi_resource_repository.resource.type.text' => [['alias' => 'text']]
        ]);

        $container->getDefinition('fsi_resource_repository.resource.type.text')->willReturn($resourceDefinition);
        $resourceDefinition->getClass()->shouldBeCalled()->willReturn(TextType::class);

        $container->setParameter('fsi_resource_repository.resource.types', [
            'text' => TextType::class
        ])->shouldBeCalled();

        $this->process($container);
    }
}
