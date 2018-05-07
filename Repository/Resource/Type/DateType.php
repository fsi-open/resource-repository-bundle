<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType as DateFormType;

class DateType extends AbstractType
{
    public function getResourceProperty(): string
    {
        return 'dateValue';
    }

    protected function getFormType(): string
    {
        return DateFormType::class;
    }
}
