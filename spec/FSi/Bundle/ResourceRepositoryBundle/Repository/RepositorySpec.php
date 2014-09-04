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
        $this->beConstructedWith($builder, $repository, 'spec\FSi\Bundle\ResourceRepositoryBundle\Repository\ResourceEntity');
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

    function it_sets_entity_field_on_existing_value(MapBuilder $builder, ResourceRepository $repository,
        TextType $resource, ResourceEntity $entity)
    {
        $repository->get('resources_group.resource_a')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');
        $entity->setTextValue('text')->shouldBeCalled();

        $this->set('resources_group.resource_a', 'text');
    }

    function it_adds_new_entity_with_field_set(MapBuilder $builder, ResourceRepository $repository,
        TextType $resource)
    {
        $repository->get('resources_group.resource_a')->willReturn(null);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');
        $repository->add(Argument::allOf(
            Argument::type('spec\FSi\Bundle\ResourceRepositoryBundle\Repository\ResourceEntity'),
            Argument::which('getTextValue', 'text')
        ))->shouldBeCalled();

        $this->set('resources_group.resource_a', 'text');
    }

    function it_removes_entity_when_setting_empty_value(MapBuilder $builder, ResourceRepository $repository,
        TextType $resource, ResourceEntity $entity)
    {
        $repository->get('resources_group.resource_a')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');
        $repository->remove($entity)->shouldBeCalled();

        $this->set('resources_group.resource_a', null);
    }
}
