<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;

class FSiImageTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('resource_group.resource_fsi_image');
    }

    function it_is_resource()
    {
        $this->shouldImplement('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface');
    }

    function it_return_text_entity_field()
    {
        $this->getResourceProperty()->shouldReturn('fileValue');
    }

    function it_return_valid_name()
    {
        $this->getName()->shouldReturn('resource_group.resource_fsi_image');
    }

    function it_return_form_builder(FormFactory $factory, FormBuilder $form)
    {
        $factory->createNamedBuilder('fileValue', 'fsi_image', null, array(
            'label' => false,
            'required' => false,
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }

    function it_return_form_builder_with_validation_constraints(FormFactory $factory, FormBuilder $form, NotBlank $constraint)
    {
        $this->addConstraint($constraint);

        $factory->createNamedBuilder('fileValue', 'fsi_image', null, array(
            'label' => false,
            'required' => false,
            'constraints' => array(
                $constraint
            )
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }

    function it_return_form_builder_with_form_options_added_to_resource_definition(FormFactory $factory, FormBuilder $form)
    {
        $this->setFormOptions(array(
            'attr' => array(
                'class' => 'class-name'
            )
        ));

        $factory->createNamedBuilder('fileValue', 'fsi_image', null, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'class-name'
            )
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }
}
