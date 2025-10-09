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
     * @param 0|1|2|4|null $lockMode
     * @param null $lockVersion
     * @return ResourceValue
     */
    public function find($id, $lockMode = null, $lockVersion = null): ResourceValue
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
        $this->getEntityManager()->persist($resourceValue);
        $this->getEntityManager()->flush();
    }

    public function add(ResourceValue $resourceValue): void
    {
        $this->getEntityManager()->persist($resourceValue);
        $this->getEntityManager()->flush();
    }

    public function remove(ResourceValue $resourceValue): void
    {
        $this->getEntityManager()->remove($resourceValue);
        $this->getEntityManager()->flush();
    }

    /**
     * Unsupported method
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @throws EntityRepositoryException
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        throw $this->throwBadMethodException('findBy');
    }

    /**
     * Unsupported method
     *
     * @return array
     * @throws EntityRepositoryException
     */
    public function findAll(): array
    {
        throw $this->throwBadMethodException('findAll');
    }

    /**
     * Unsupported method
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @return ResourceValue|null
     * @throws EntityRepositoryException
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?ResourceValue
    {
        throw $this->throwBadMethodException('findOneBy');
    }

    /**
     * @param string $method
     */
    private function throwBadMethodException(string $method): EntityRepositoryException
    {
        return new EntityRepositoryException(sprintf(
            'Method "%s" is not supported in "%s" entity repository',
            $method,
            $this->getEntityName()
        ));
    }
}
