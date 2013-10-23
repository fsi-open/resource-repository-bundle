<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use FSi\Bundle\ResourceRepositoryBundle\Entity\ResourceRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Repository
{
    /**
     * @var MapBuilder
     */
    protected $builder;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $er;

    /**
     * @param MapBuilder $builder
     * @param \FSi\Bundle\ResourceRepositoryBundle\Entity\ResourceRepository $er
     */
    public function __construct(MapBuilder $builder, ObjectRepository $er)
    {
        $this->builder = $builder;
        $this->er = $er;
    }

    /**
     * Get resource by key
     *
     * @param string $key
     * @return null|mixed
     */
    public function get($key)
    {
        $entity = $this->er->get( $key);

        if (!isset($entity)) {
            return null;
        }

        $resource = $this->builder->getResource($key);
        $accessor = PropertyAccess::createPropertyAccessor();
        $value = $accessor->getValue($entity, $resource->getResourceProperty());

        if (isset($value) && !(is_string($value) && empty($value))) {
            return $value;
        }

        return null;
    }
}