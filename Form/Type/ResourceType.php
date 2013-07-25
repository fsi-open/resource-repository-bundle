<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourceType extends AbstractType
{
    /**
     * @var \FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder
     */
    protected $map;

    /**
     * @param MapBuilder $map
     */
    function __construct(MapBuilder $map)
    {
        $this->map = $map;
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
    }

    /**
     * @inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();

        if (!isset($data)) {
            throw new ResourceFormTypeException('ResourceType form data can not be null');
        }

        $resource = $this->map->getResource($data->getKey());
        $elementBuilder = $resource->getFormBuilder($builder->getFormFactory());

        $builder->add($elementBuilder);
    }
}
