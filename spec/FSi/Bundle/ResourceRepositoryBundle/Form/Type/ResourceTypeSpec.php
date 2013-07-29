<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Entity\Resource;
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
        $resolver->setDefaults(array(
            'data_class' => 'FSi\Bundle\ResourceRepositoryBundle\Entity\Resource',
        ))->shouldBeCalled();

        $this->setDefaultOptions($resolver);
    }

    function it_build_form_for_resource_type_text(MapBuilder $map, FormBuilder $formBuilder, TextType $resource,
            FormFactory $formFactory, FormBuilder $elementBuilder, Resource $resourceEntity)
    {

        $map->getResource(Argument::any())->willReturn($resource);
        $resource->getFormBuilder(Argument::type('Symfony\Component\Form\FormFactory'))->shouldBeCalled()->willReturn($elementBuilder);

        $formBuilder->getFormFactory()->willReturn($formFactory);
        $formBuilder->add(Argument::type('Symfony\Component\Form\FormBuilder'))->shouldBeCalled();
        $formBuilder->getData()->willReturn($resourceEntity);
        $resourceEntity->getKey()->willReturn('resources.resource_a');

        $this->buildForm($formBuilder, array());
    }

    function it_throw_exception_when_form_data_is_null(FormBuilder $formBuilder)
    {
        $formBuilder->getData()->willReturn(null);

        $this->shouldThrow(
            new ResourceFormTypeException('ResourceType form data can not be null')
        )->during('buildForm', array($formBuilder, array()));
    }
}
