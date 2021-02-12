<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\DoctrineExtensionsBundle\Form\Type\FSi\RemovableFileType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;

class FSiRemovableFileTypeSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('resource_group.resource_fsi_removable_file');
    }

    public function it_is_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    public function it_return_text_entity_field(): void
    {
        $this->getResourceProperty()->shouldReturn('fileValue');
    }

    public function it_return_valid_name(): void
    {
        $this->getName()->shouldReturn('resource_group.resource_fsi_removable_file');
    }

    public function it_return_form_builder(FormFactory $factory, FormBuilder $form): void
    {
        $factory->createNamedBuilder('fileValue', RemovableFileType::class, null, [
            'label' => false,
            'required' => false,
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturn($form);
    }

    public function it_return_form_builder_with_validation_constraints(
        FormFactory $factory,
        FormBuilder $form,
        NotBlank $constraint
    ): void {
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

    public function it_return_form_builder_with_form_options_added_to_resource_definition(
        FormFactory $factory,
        FormBuilder $form
    ): void {
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

    public function it_returns_form_builder_with_additional_file_options_and_file_constraints(
        FormFactory $factory,
        FormBuilder $form,
        NotBlank $constraint
    ): void {
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
