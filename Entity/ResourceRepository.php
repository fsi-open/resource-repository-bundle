<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Entity;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException;

class ResourceRepository extends EntityRepository
{
    /**
     * @param mixed $id
     * @param int $lockMode
     * @param null $lockVersion
     * @return \FSi\Bundle\ResourceRepositoryBundle\Model\ResourceInterface
     */
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
    {
        $resource = parent::find($id, $lockMode, $lockVersion);

        if (!isset($resource)) {
            $resourceClass = $this->getClassName();
            $resource = new $resourceClass();
            $resource->setKey($id);
        }

        return $resource;
    }

    /**
     * @param $key
     * @return \FSi\Bundle\ResourceRepositoryBundle\Model\ResourceInterface
     */
    public function get($key)
    {
        return $this->find($key);
    }

    /**
     * Unsupported method
     *
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|void
     * @throws \FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        throw new EntityRepositoryException('Method "findBy" is not supported in "FSiResourceRepository:Resource" entity repository');
    }

    /**
     * Unsupported method
     *
     * @return array|void
     * @throws \FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException
     */
    public function findAll()
    {
        throw new EntityRepositoryException('Method "findAll" is not supported in "FSiResourceRepository:Resource" entity repository');
    }

    /**
     * Unsupported method
     *
     * @param array $criteria
     * @param array $orderBy
     * @return object|void
     * @throws \FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        throw new EntityRepositoryException('Method "findOneBy" is not supported in "FSiResourceRepository:Resource" entity repository');
    }
}