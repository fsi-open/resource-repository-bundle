<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ResourcePassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\Compiler\ResourcePass');
    }

    function it_is_complier_pass()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_should_replace_resource_types_parameters_with_array_of_resources(ContainerBuilder $container,
         Definition $resourceDefinition)
    {
        $container->findTaggedServiceIds('resource.type')->shouldBeCalled()->willReturn([
            'fsi_resource_repository.resource.type.text' => [
                0 => [
                    'alias' => 'text'
                ]
            ]
        ]);

        $container->getDefinition('fsi_resource_repository.resource.type.text')->willReturn($resourceDefinition);
        $resourceDefinition->getClass()
            ->shouldBeCalled()
            ->willReturn('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType');


        $container->setParameter('fsi_resource_repository.resource.types', [
            'text' => 'FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType'
        ])->shouldBeCalled();

        $this->process($container);
    }
}
