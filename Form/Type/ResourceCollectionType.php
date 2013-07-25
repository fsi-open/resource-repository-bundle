<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Entity\Resource;
use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourceCollectionType extends AbstractType
{
    /**
     * @inheritdoc}
     */
    public function getName()
    {
        return 'resource_collection';
    }

    /**
     * @inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();
        $this->validateData($data);

        $factory = $builder->getFormFactory();

        foreach ($data as $index => $resourceEntity) {
            $builder->add($factory->createNamedBuilder($index, 'resource', $resourceEntity));
        }
    }

    /**
     * @param $data
     * @throws \FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException
     */
    protected function validateData($data)
    {
        if (!isset($data)) {
            throw new ResourceFormTypeException('ResourceCollectionType form data can not be null');
        }

        if (!is_array($data) && !($data instanceof \Traversable && $data instanceof \ArrayAccess)) {
            throw new ResourceFormTypeException('ResourceCollectionType form data must be an array or (\Traversable and \ArrayAccess)');
        }

        foreach ($data as $index => $resourceEntity) {
            if (!$resourceEntity instanceof Resource) {
                throw new ResourceFormTypeException(sprintf('Index "%d" in data array is not a valid resource', $index));
            }
        }
    }
}
