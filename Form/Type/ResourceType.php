<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use FSi\Bundle\ResourceRepositoryBundle\Form\EventListener\AddResourceKeySubscriber;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourceType extends AbstractType
{
    /**
     * @var \FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder
     */
    protected $mapBuilder;

    /**
     * @param MapBuilder $map
     */
    function __construct(MapBuilder $mapBuilder)
    {
        $this->mapBuilder = $mapBuilder;
    }

    /**
     * @inheritdoc}
     */
    public function getName()
    {
        return 'resource';
    }

    /**
     * @inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FSi\Bundle\ResourceRepositoryBundle\Entity\Resource',
        ));

        $resolver->setRequired(array(
            'resource_key'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->mapBuilder->hasResource($options['resource_key'])) {
            throw new ResourceFormTypeException(sprintf('"%s" is not a valid resource key', $options['resource_key']));
        }

        $resource = $this->mapBuilder->getResource($options['resource_key']);
        $resourceFormBuilder = $resource->getFormBuilder($builder->getFormFactory());

        $builder->add($resourceFormBuilder);
        $builder->addEventSubscriber(new AddResourceKeySubscriber());
    }
}
