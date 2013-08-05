<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Form\EventListener;

use FSi\Bundle\ResourceRepositoryBundle\Entity\Resource;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddResourceKeySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SUBMIT => 'postSubmit');
    }

    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if ($form->getName() === 'resource') {
            $options = $form->getConfig()->getOptions();

            if ($data instanceof Resource && array_key_exists('resource_key', $options)) {
                $data->setKey($options['resource_key']);

                $event->setData($data);
            }
        }
    }
}