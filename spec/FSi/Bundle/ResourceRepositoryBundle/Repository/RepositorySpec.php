<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository;

use FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository;
use FSi\Bundle\ResourceRepositoryBundle\Model\Resource;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceEntity extends Resource
{
}

class RepositorySpec extends ObjectBehavior
{
    function let(MapBuilder $builder, ResourceRepository $repository)
    {
        $this->beConstructedWith($builder, $repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Repository\Repository');
    }

    function it_return_null_if_resource_entity_does_not_exist(ResourceRepository $repository)
    {
        $repository->get('resources_group.resource_a')->shouldBeCalled()->willReturn(null);

        $this->get('resources_group.resource_a')->shouldReturn(null);
    }

    function it_return_null_if_entity_field_is_null(MapBuilder $builder, ResourceRepository $repository,
            TextType $resource, ResourceEntity $entity)
    {
        $entity->getTextValue()->shouldBeCalled()->willReturn(null);
        $repository->get('resources_group.resource_a')->shouldBeCalled()->willReturn($entity);
        $builder->getResource(Argument::type('string'))->shouldBeCalled()->willReturn($resource);
        $resource->getResourceProperty()->shouldBeCalled()->willReturn('textValue');

        $this->get('resources_group.resource_a')->shouldReturn(null);
    }

    function it_return_null_if_entity_field_is_empty_string(MapBuilder $builder, ResourceRepository $repository,
             TextType $resource, ResourceEntity $entity)
    {
        $entity->getTextValue()->shouldBeCalled()->willReturn('');
        $repository->get('resources_group.resource_a')->shouldBeCalled()->willReturn($entity);
        $builder->getResource(Argument::type('string'))->shouldBeCalled()->willReturn($resource);
        $resource->getResourceProperty()->shouldBeCalled()->willReturn('textValue');

        $this->get('resources_group.resource_a')->shouldReturn(null);
    }

    function it_return_0_if_entity_field_is_zero(MapBuilder $builder, ResourceRepository $repository,
             TextType $resource, ResourceEntity $entity)
    {
        $entity->getTextValue()->shouldBeCalled()->willReturn(0);
        $repository->get('resources_group.resource_a')->shouldBeCalled()->willReturn($entity);
        $builder->getResource(Argument::type('string'))->shouldBeCalled()->willReturn($resource);
        $resource->getResourceProperty()->shouldBeCalled()->willReturn('textValue');

        $this->get('resources_group.resource_a')->shouldReturn(0);
    }
}
