<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\DoctrineExtensionsBundle\Form\Type\FSi\RemovableFileType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;

class FSiRemovableFileTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('resource_group.resource_fsi_removable_file');
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
        $this->getName()->shouldReturn('resource_group.resource_fsi_removable_file');
    }

    function it_return_form_builder(FormFactory $factory, FormBuilder $form)
    {
        $factory->createNamedBuilder('fileValue', RemovableFileType::class, null, [
            'label' => false,
            'required' => false,
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }

    function it_return_form_builder_with_validation_constraints(FormFactory $factory, FormBuilder $form, NotBlank $constraint)
    {
        $this->addConstraint($constraint);

        $factory->createNamedBuilder('fileValue', RemovableFileType::class, null, [
            'label' => false,
            'required' => false,
            'file_options' => [
                'constraints' => [
                    $constraint
                ]
            ]
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }

    function it_return_form_builder_with_form_options_added_to_resource_definition(FormFactory $factory, FormBuilder $form)
    {
        $this->setFormOptions([
            'file_type' => 'fsi_image'
        ]);

        $factory->createNamedBuilder('fileValue', RemovableFileType::class, null, [
            'label' => false,
            'required' => false,
            'file_type' => 'fsi_image'
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }

    function it_returns_form_builder_with_additional_file_options_and_file_constraints(
        FormFactory $factory,
        FormBuilder $form,
        NotBlank $constraint
    ) {
        $this->addConstraint($constraint);

        $this->setFormOptions([
            'file_type' => 'fsi_image',
            'file_options' => ['file_option' => 'value']
        ]);

        $factory->createNamedBuilder('fileValue', RemovableFileType::class, null, [
            'label' => false,
            'required' => false,
            'file_type' => 'fsi_image',
            'file_options' => [
                'file_option' => 'value',
                'constraints' => [$constraint]
            ],
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }
}
