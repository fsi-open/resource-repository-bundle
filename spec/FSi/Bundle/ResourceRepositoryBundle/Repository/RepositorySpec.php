<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository;

use FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use tests\FSi\Bundle\ResourceRepositoryBundle\Entity\Resource;

class RepositorySpec extends ObjectBehavior
{
    public function let(MapBuilder $builder, ResourceRepository $repository): void
    {
        $this->beConstructedWith($builder, $repository, Resource::class);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Repository::class);
    }

    public function it_return_null_if_resource_entity_does_not_exist(MapBuilder $builder): void
    {
        $builder->getResource('resources_group.resource_a')->willReturn(null);
        $this->get('resources_group.resource_a')->shouldReturn(null);
    }

    public function it_return_null_if_entity_field_is_null(
        MapBuilder $builder,
        ResourceRepository $repository,
        TextType $resource,
        Resource $entity
    ): void {
        $entity->getTextValue()->willReturn(null);
        $resource->getName()->willReturn('resources_group.resource_a.en');
        $repository->get('resources_group.resource_a.en')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');

        $this->get('resources_group.resource_a')->shouldReturn(null);
    }

    public function it_return_null_if_entity_field_is_empty_string(
        MapBuilder $builder,
        ResourceRepository $repository,
        TextType $resource,
        Resource $entity
    ): void {
        $entity->getTextValue()->willReturn('');
        $resource->getName()->willReturn('resources_group.resource_a.en');
        $repository->get('resources_group.resource_a.en')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');

        $this->get('resources_group.resource_a')->shouldReturn(null);
    }

    public function it_return_0_if_entity_field_is_zero(
        MapBuilder $builder,
        ResourceRepository $repository,
        TextType $resource,
        Resource $entity
    ): void {
        $entity->getTextValue()->willReturn(0);
        $resource->getName()->willReturn('resources_group.resource_a.en');
        $repository->get('resources_group.resource_a.en')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');

        $this->get('resources_group.resource_a')->shouldReturn(0);
    }

    public function it_sets_entity_field_on_existing_value(
        MapBuilder $builder,
        ResourceRepository $repository,
        TextType $resource,
        Resource $entity
    ): void {
        $resource->getName()->willReturn('resources_group.resource_a.en');
        $repository->get('resources_group.resource_a.en')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');
        $repository->add(Argument::type(Resource::class))->shouldBeCalled();

        $this->set('resources_group.resource_a', 'text');
    }

    public function it_removes_entity_when_setting_empty_value(
        MapBuilder $builder,
        ResourceRepository $repository,
        TextType $resource,
        Resource $entity
    ): void {
        $resource->getName()->willReturn('resources_group.resource_a.en');
        $repository->get('resources_group.resource_a.en')->willReturn($entity);
        $builder->getResource(Argument::type('string'))->willReturn($resource);
        $resource->getResourceProperty()->willReturn('textValue');
        $repository->remove($entity)->shouldBeCalled();

        $this->set('resources_group.resource_a', null);
    }
}
