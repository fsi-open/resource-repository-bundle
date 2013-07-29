<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Entity\Resource;
use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;

class ResourceCollectionTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Form\Type\ResourceCollectionType');
    }

    function it_is_form_type()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\Form\AbstractType');
    }

    function it_is_called_resource()
    {
        $this->getName()->shouldReturn('resource_collection');
    }

    function it_throw_exception_during_buildForm_when_builder_data_is_null(FormBuilder $formBuilder)
    {
        $formBuilder->getData()->willReturn(null);

        $this->shouldThrow(
            new ResourceFormTypeException('ResourceCollectionType form data can not be null')
        )->during('buildForm', array($formBuilder, array()));
    }

    function it_throw_exception_during_buildForm_when_builder_data_is_not_array(FormBuilder $formBuilder)
    {
        $formBuilder->getData()->willReturn('This is not an array');

        $this->shouldThrow(
            new ResourceFormTypeException('ResourceCollectionType form data must be an array or (\Traversable and \ArrayAccess)')
        )->during('buildForm', array($formBuilder, array()));
    }

    function it_build_simple_form_with_resources_as_list(FormBuilder $formBuilder, FormFactory $factory)
    {
        $resources = array(
            new Resource('resources.resource_text'),
            new Resource('resources.resource_integer'),
            new Resource('resources.resource_datetime')
        );

        $formBuilder->getData()->willReturn($resources);

        $formBuilder->getFormFactory()->willReturn($factory);
        $factory->createNamedBuilder(0, 'resource', $resources[0])->shouldBeCalled()->willReturn($formBuilder);
        $factory->createNamedBuilder(1, 'resource', $resources[1])->shouldBeCalled()->willReturn($formBuilder);
        $factory->createNamedBuilder(2, 'resource', $resources[2])->shouldBeCalled()->willReturn($formBuilder);

        $formBuilder->add(Argument::type('Symfony\Component\Form\FormBuilder'))->shouldBeCalledTimes(3);

        $this->buildForm($formBuilder, array());
    }

    function it_throw_exception_when_one_of_data_array_elements_is_not_a_resource(FormBuilder $formBuilder)
    {
        $resources = array(
            'this_is_not_a_valid_resource',
            new Resource('resources.resource_integer'),
            new Resource('resources.resource_datetime')
        );

        $formBuilder->getData()->willReturn($resources);

        $this->shouldThrow(
            new ResourceFormTypeException('Index "0" in data array is not a valid resource')
        )->during('buildForm', array($formBuilder, array()));
    }
}
