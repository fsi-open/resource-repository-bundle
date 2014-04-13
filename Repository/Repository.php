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

class Repository
{
    /**
     * @var MapBuilder
     */
    protected $builder;

    /**
     * @var \FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValueRepository
     */
    protected $rvr;

    /**
     * @param MapBuilder $builder
     * @param \FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValueRepository $rvr
     */
    public function __construct(MapBuilder $builder, ResourceValueRepository $rvr)
    {
        $this->builder = $builder;
        $this->rvr = $rvr;
    }

    /**
     * Get resource by key
     *
     * @param string $key
     * @return null|mixed
     */
    public function get($key)
    {
        $entity = $this->rvr->get($key);

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
