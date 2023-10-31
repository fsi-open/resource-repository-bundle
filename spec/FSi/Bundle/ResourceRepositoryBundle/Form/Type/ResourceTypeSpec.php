<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use FSi\Bundle\ResourceRepositoryBundle\Form\Type\ResourceType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use FSi\Bundle\ResourceRepositoryBundle\Tests\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceTypeSpec extends ObjectBehavior
{
    public function let(MapBuilder $map): void
    {
        $this->beConstructedWith($map, Resource::class);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceType::class);
    }

    public function it_is_form_type(): void
    {
        $this->shouldBeAnInstanceOf(AbstractType::class);
    }

    public function it_is_called_resource(): void
    {
        $this->getName()->shouldReturn('resource');
    }

    public function it_configures_options(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Resource::class])->shouldBeCalled()->willReturn($resolver);
        $resolver->setRequired(['resource_key'])->shouldBeCalled()->willReturn($resolver);
        $this->configureOptions($resolver);
    }

    public function it_should_throw_exception_during_build_form_when_resource_key_is_invalid(
        MapBuilder $map,
        FormBuilder $builder
    ): void {
        $map->hasResource('resources.invalid_resource')->willReturn(false);

        $this->shouldThrow(
            new ResourceFormTypeException('"resources.invalid_resource" is not a valid resource key')
        )->duringBuildForm($builder, ['resource_key' => 'resources.invalid_resource']);
    }

    public function it_add_form_builder_specified_by_resource_definition(
        MapBuilder $map,
        FormBuilder $builder,
        TextType $resource,
        FormFactory $factory,
        FormBuilder $textBuilder
    ): void {
        $map->hasResource('resources.resource_text')->willReturn(true);
        $map->getResource('resources.resource_text')->shouldBeCalled()->willReturn($resource);
        $builder->getFormFactory()->willReturn($factory);
        $resource->getFormBuilder($factory)->shouldBeCalled()->willReturn($textBuilder);
        $builder->add($textBuilder)->shouldBeCalled()->willReturn($builder);
        $this->buildForm($builder, ['resource_key' => 'resources.resource_text']);
    }
}
