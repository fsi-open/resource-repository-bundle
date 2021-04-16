<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\AbstractType;
use FSi\Component\Files\Integration\Symfony\Form;

final class WebFileType extends AbstractType
{
    public function getResourceProperty(): string
    {
        return 'fileValue';
    }

    protected function getFormType(): string
    {
        return Form\WebFileType::class;
    }
}
