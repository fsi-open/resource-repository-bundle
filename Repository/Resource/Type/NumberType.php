<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\Extension\Core\Type\NumberType as NumberFormType;

class NumberType extends AbstractType
{
    public function getResourceProperty(): string
    {
        return 'numberValue';
    }

    protected function getFormType(): string
    {
        return NumberFormType::class;
    }

    protected function buildFormOptions(): array
    {
        return array_merge(['scale' => 4], parent::buildFormOptions());
    }
}
