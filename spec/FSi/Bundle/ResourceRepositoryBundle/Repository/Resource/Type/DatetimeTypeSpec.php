<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\DatetimeType as FSiDatetimeType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
        $this->shouldHaveType(FSiDatetimeType::class);
    }

    function it_is_resource()
    {
        $this->shouldImplement(ResourceInterface::class);
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
        $factory->createNamedBuilder('datetimeValue', DateTimeType::class, null, [
            'label' => false,
            'required' => false,
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf(FormBuilder::class);
    }

    function it_return_form_builder_with_validation_constraints(FormFactory $factory, FormBuilder $form, NotBlank $constraint)
    {
        $this->addConstraint($constraint);

        $factory->createNamedBuilder('datetimeValue', DateTimeType::class, null, [
            'label' => false,
            'required' => false,
            'constraints' => [$constraint]
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf(FormBuilder::class);
    }

    function it_return_form_builder_with_form_options_added_to_resource_definition(FormFactory $factory, FormBuilder $form)
    {
        $this->setFormOptions(['attr' => ['class' => 'class-name']]);

        $factory->createNamedBuilder('datetimeValue', DateTimeType::class, null, [
            'label' => false,
            'required' => false,
            'attr' => ['class' => 'class-name']
        ])->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf(FormBuilder::class);
    }
}
