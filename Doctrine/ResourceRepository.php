<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Doctrine;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValueRepository;

class ResourceRepository extends EntityRepository implements ResourceValueRepository
{
    /**
     * @param mixed $id
     * @param int $lockMode
     * @param null $lockVersion
     * @return ResourceValue
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        if ($lockMode === null) {
            $lockMode = LockMode::NONE;
        }
        $resource = parent::find($id, $lockMode, $lockVersion);

        if (null === $resource) {
            $resourceClass = $this->getClassName();
            $resource = new $resourceClass();
            $resource->setKey($id);
        }

        return $resource;
    }

    public function get(string $key): ResourceValue
    {
        return $this->find($key);
    }

    public function save(ResourceValue $resourceValue): void
    {
        $this->_em->persist($resourceValue);
        $this->_em->flush();
    }

    public function add(ResourceValue $resourceValue): void
    {
        $this->save($resourceValue);
    }

    public function remove(ResourceValue $resourceValue): void
    {
        $this->_em->remove($resourceValue);
        $this->_em->flush();
    }

    /**
     * Unsupported method
     *
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|void
     * @throws EntityRepositoryException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $this->throwBadMethodException('findBy');
    }

    /**
     * Unsupported method
     *
     * @return array|void
     * @throws EntityRepositoryException
     */
    public function findAll()
    {
        $this->throwBadMethodException('findAll');
    }

    /**
     * Unsupported method
     *
     * @param array $criteria
     * @param array $orderBy
     * @return object|void
     * @throws EntityRepositoryException
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $this->throwBadMethodException('findOneBy');
    }

    /**
     * @param string $method
     * @throws EntityRepositoryException
     */
    private function throwBadMethodException(string $method): void
    {
        throw new EntityRepositoryException(sprintf(
            'Method "%s" is not supported in "%s" entity repository',
            $method,
            $this->getEntityName()
        ));
    }
}
