<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;

class DatetimeTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('resource_group.resource_datetime');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\DatetimeType');
    }

    function it_is_resource()
    {
        $this->shouldImplement('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface');
    }

    function it_return_checkbox_entity_field()
    {
        $this->getResourceProperty()->shouldReturn('datetimeValue');
    }

    function it_return_valid_name()
    {
        $this->getName()->shouldReturn('resource_group.resource_datetime');
    }

    function it_return_form_builder(FormFactory $factory, FormBuilder $form)
    {
        $factory->createNamedBuilder('datetimeValue', 'datetime', null, array(
            'label' => 'resource_group.resource_datetime.name',
            'required' => false,
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }

    function it_return_form_builder_with_validation_constraints(FormFactory $factory, FormBuilder $form, NotBlank $constraint)
    {
        $this->addConstraint($constraint);

        $factory->createNamedBuilder('datetimeValue', 'datetime', null, array(
            'label' => 'resource_group.resource_datetime.name',
            'required' => false,
            'constraints' => array(
                $constraint
            )
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }
}
