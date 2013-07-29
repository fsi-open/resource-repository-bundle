<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class UrlTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('resource_group.resource_url');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\UrlType');
    }

    function it_is_resource()
    {
        $this->shouldImplement('FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface');
    }

    function it_return_url_entity_field()
    {
        $this->getResourceProperty()->shouldReturn('textValue');
    }

    function it_return_valid_name()
    {
        $this->getName()->shouldReturn('resource_group.resource_url');
    }

    function it_return_form_builder(FormFactory $factory, FormBuilder $form)
    {
        $factory->createNamedBuilder('textValue', 'url', null, array(
            'label' => 'resource_group.resource_url.name',
            'required' => false,
            'constraints' => array(
                new Url()
            )
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }

    function it_return_form_builder_with_validation_constraints(FormFactory $factory, FormBuilder $form, NotBlank $notBlank)
    {
        $this->addConstraint($notBlank);

        $factory->createNamedBuilder('textValue', 'url', null, array(
            'label' => 'resource_group.resource_url.name',
            'required' => false,
            'constraints' => array(
                new Url(),
                $notBlank
            )
        ))->shouldBeCalled()->willReturn($form);

        $this->getFormBuilder($factory)->shouldReturnAnInstanceOf('Symfony\Component\Form\FormBuilder');
    }
}