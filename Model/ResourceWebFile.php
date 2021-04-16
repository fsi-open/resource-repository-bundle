<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Model;

use FSi\Bundle\ResourceRepositoryBundle\Model\Resource;
use FSi\Component\Files\WebFile;

class ResourceWebFile extends Resource
{
    protected ?WebFile $fileValue = null;
    protected ?string $fileKeyValue = null;

    public function getFileValue(): ?WebFile
    {
        return $this->fileValue;
    }

    public function setFileValue(?WebFile $fileValue): void
    {
        $this->fileValue = $fileValue;
    }

    public function getFileKeyValue(): ?string
    {
        return $this->fileKeyValue;
    }

    public function setFileKeyValue(?string $fileKeyValue): void
    {
        $this->fileKeyValue = $fileKeyValue;
    }
}
