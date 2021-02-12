<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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

    public function __construct(
        MapBuilder $builder,
        ResourceValueRepository $valueRepository,
        string $resourceValueClass
    ) {
        $this->builder = $builder;
        $this->resourceValueRepository = $valueRepository;
        $this->resourceValueClass = $resourceValueClass;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param string $key
     * @return null|mixed
     */
    public function get(string $key)
    {
        $resource = $this->builder->getResource($key);
        if (null === $resource) {
            return null;
        }

        $entity = $this->resourceValueRepository->get($resource->getName());

        $value = $this->accessor->getValue($entity, $resource->getResourceProperty());
        if (null !== $value && !(is_string($value) && empty($value))) {
            return $value;
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $resource = $this->builder->getResource($key);

        $entity = $this->resourceValueRepository->get($resource->getName());
        if (null === $value) {
            $this->resourceValueRepository->remove($entity);
        } else {
            $this->accessor->setValue($entity, $resource->getResourceProperty(), $value);
            $this->resourceValueRepository->save($entity);
        }
    }
}
