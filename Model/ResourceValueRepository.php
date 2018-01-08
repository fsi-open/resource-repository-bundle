<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Model;

interface ResourceValueRepository
{
    public function get(string $key): ResourceValue;

    public function add(ResourceValue $resourceValue): void;

    public function save(ResourceValue $resourceValue): void;

    public function remove(ResourceValue $resourceValue): void;
}
