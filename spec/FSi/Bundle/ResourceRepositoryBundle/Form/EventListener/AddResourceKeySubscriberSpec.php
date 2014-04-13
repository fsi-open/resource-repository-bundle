<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Form\EventListener;

use FSi\Bundle\ResourceRepositoryBundle\Model\Resource;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddResourceKeySubscriberSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Form\EventListener\AddResourceKeySubscriber');
    }

    function it_is_subscribing_post_submit_event()
    {
        $this->getSubscribedEvents()->shouldReturn(array(
            FormEvents::POST_SUBMIT => 'postSubmit'
        ));
    }

    function it_set_key_taken_from_form_to_data_entity(FormEvent $event, Form $form, ResourceValue $entity, FormConfigInterface $config)
    {
        $form->getConfig()->willReturn($config);
        $config->getOptions()->willReturn(array(
            'resource_key' => 'resources.resource_a'
        ));
        $entity->setKey('resources.resource_a')->shouldBeCalled();

        $event->getForm()->shouldBeCalled()->willReturn($form);
        $event->getData()->shouldBeCalled()->willReturn($entity);

        $event->setData(Argument::type('FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue'))->shouldBeCalled();
        $this->postSubmit($event);
    }
}