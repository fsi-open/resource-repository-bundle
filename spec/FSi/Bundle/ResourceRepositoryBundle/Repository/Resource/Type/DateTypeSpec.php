<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\DateType as FSiDateType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;

class DateTypeSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('resource_group.resource_date');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FSiDateType::class);
    }

    public function it_is_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    public function it_return_checkbox_entity_field(): void
    {
        $this->getResourceProperty()->shouldReturn('dateValue');
    }

    public function it_return_valid_name(): void
    {
        $this->getName()->shouldReturn('resource_group.resource_date');
    }

    public function it_return_form_builder(FormFactory $factory, FormBuilder $form): void
    {
        $factory->createNamedBuilder('dateValue', DateType::class, null, [
            'label' => false,
            'required' => false,
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf(FormBuilder::class);
    }

    public function it_return_form_builder_with_validation_constraints(
        FormFactory $factory,
        FormBuilder $form,
        NotBlank $constraint
    ): void {
        $this->addConstraint($constraint);

        $factory->createNamedBuilder('dateValue', DateType::class, null, [
            'label' => false,
            'required' => false,
            'constraints' => [
                $constraint
            ]
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf(FormBuilder::class);
    }

    public function it_return_form_builder_with_form_options_added_to_resource_definition(
        FormFactory $factory,
        FormBuilder $form
    ): void {
        $this->setFormOptions([
            'attr' => [
                'class' => 'class-name'
            ]
        ]);

        $factory->createNamedBuilder('dateValue', DateType::class, null, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => 'class-name'
            ]
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf(FormBuilder::class);
    }
}
