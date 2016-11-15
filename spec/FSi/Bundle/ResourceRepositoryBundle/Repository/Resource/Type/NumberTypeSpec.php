<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;

class NumberTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('resource_group.resource_number');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\NumberType');
    }

    function it_is_resource()
    {
        $this->shouldImplement('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface');
    }

    function it_return_email_entity_field()
    {
        $this->getResourceProperty()->shouldReturn('numberValue');
    }

    function it_return_valid_name()
    {
        $this->getName()->shouldReturn('resource_group.resource_number');
    }

    function it_return_form_builder(FormFactory $factory, FormBuilder $form)
    {
        $factory->createNamedBuilder('numberValue', NumberType::class, null, [
            'label' => false,
            'required' => false,
            'precision' => 4
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }

    function it_return_form_builder_with_validation_constraints(FormFactory $factory, FormBuilder $form, NotBlank $notBlank)
    {
        $this->addConstraint($notBlank);

        $factory->createNamedBuilder('numberValue', NumberType::class, null, [
            'label' => false,
            'required' => false,
            'constraints' => [
                $notBlank
            ],
            'precision' => 4
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }

    function it_return_form_builder_with_form_options_added_to_resource_definition(FormFactory $factory, FormBuilder $form)
    {
        $this->setFormOptions([
            'attr' => [
                'class' => 'class-name'
            ]
        ]);

        $factory->createNamedBuilder('numberValue', NumberType::class, null, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => 'class-name'
            ],
            'precision' => 4
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }

    function it_should_allow_override_form_options(FormFactory $factory, FormBuilder $form)
    {
        $this->setFormOptions(['precision' => 8]);

        $factory->createNamedBuilder('numberValue', NumberType::class, null, [
            'label' => false,
            'required' => false,
            'precision' => 8
        ])->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }
}
