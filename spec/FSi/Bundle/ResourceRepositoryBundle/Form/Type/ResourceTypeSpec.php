<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Model\Resource;
use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceTypeSpec extends ObjectBehavior
{
    function let(MapBuilder $map)
    {
        $this->beConstructedWith($map);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Form\Type\ResourceType');
    }

    function it_is_form_type()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\Form\AbstractType');
    }

    function it_is_called_resource()
    {
        $this->getName()->shouldReturn('resource');
    }

    function it_should_have_default_data_class_and_resource_key_option(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'resource_key'
        ))->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    function it_should_throw_exception_during_build_form_when_resource_key_is_invalid(MapBuilder $map, FormBuilder $builder)
    {
        $map->hasResource('resources.invalid_resource')->willReturn(false);

        $this->shouldThrow(
            new ResourceFormTypeException('"resources.invalid_resource" is not a valid resource key')
        )->duringBuildForm($builder, array(
            'resource_key' => 'resources.invalid_resource'
        ));
    }

    function it_add_form_builder_specified_by_resource_definition(MapBuilder $map, FormBuilder $builder, TextType $resource,
            FormFactory $factory, FormBuilder $textBuilder)
    {
        $map->hasResource('resources.resource_text')->willReturn(true);
        $map->getResource('resources.resource_text')->shouldBeCalled()->willReturn($resource);
        $builder->getFormFactory()->willReturn($factory);
        $resource->getFormBuilder($factory)->shouldBeCalled()->willReturn($textBuilder);

        $builder->add($textBuilder)->shouldBeCalled();

        $builder->addEventSubscriber(Argument::type('FSi\Bundle\ResourceRepositoryBundle\Form\EventListener\AddResourceKeySubscriber'))
            ->shouldBeCalled();

        $this->buildForm($builder, array(
            'resource_key' => 'resources.resource_text'
        ));
    }
}
