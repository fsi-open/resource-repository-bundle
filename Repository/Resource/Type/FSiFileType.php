<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\DoctrineExtensionsBundle\Form\Type\FSi\FileType as FSiFileFormType;

class FSiFileType extends AbstractType
{
    public function getResourceProperty(): string
    {
        return 'fileValue';
    }

    protected function getFormType(): string
    {
        return FSiFileFormType::class;
    }
}
