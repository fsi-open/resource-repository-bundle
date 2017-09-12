<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Repository;

use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValueRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class Repository
{
    /**
     * @var MapBuilder
     */
    protected $builder;

    /**
     * @var ResourceValueRepository
     */
    protected $resourceValueRepository;

    /**
     * @var string
     */
    protected $resourceValueClass;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    /**
     * @param MapBuilder $builder
     * @param ResourceValueRepository $valueRepository
     * @param string $resourceValueClass
     */
    public function __construct(
        MapBuilder $builder,
        ResourceValueRepository $valueRepository,
        $resourceValueClass
    ) {
        $this->builder = $builder;
        $this->resourceValueRepository = $valueRepository;
        $this->resourceValueClass = $resourceValueClass;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Get resource by key
     *
     * @param string $key
     * @return null|mixed
     */
    public function get($key)
    {
        $resource = $this->builder->getResource($key);
        if (!isset($resource)) {
            return null;
        }

        $entity = $this->resourceValueRepository->get($resource->getName());
        if (!isset($entity)) {
            return null;
        }

        $value = $this->accessor->getValue($entity, $resource->getResourceProperty());
        if (isset($value) && !(is_string($value) && empty($value))) {
            return $value;
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed
     */
    public function set($key, $value)
    {
        $resource = $this->builder->getResource($key);

        $entity = $this->resourceValueRepository->get($resource->getName());
        if (isset($entity) && !isset($value)) {
            $this->resourceValueRepository->remove($entity);
            return;
        }

        if (isset($entity)) {
            $this->accessor->setValue($entity, $resource->getResourceProperty(), $value);
            $this->resourceValueRepository->save($entity);
        } else {
            $entity = new $this->resourceValueClass();
            $this->accessor->setValue($entity, $resource->getResourceProperty(), $value);
            $this->resourceValueRepository->add($entity);
        }
    }
}
