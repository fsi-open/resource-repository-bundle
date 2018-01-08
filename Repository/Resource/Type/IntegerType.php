<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\Extension\Core\Type\IntegerType as IntegerFormType;

class IntegerType extends AbstractType
{
    public function getResourceProperty(): string
    {
        return 'integerValue';
    }

    protected function getFormType(): string
    {
        return IntegerFormType::class;
    }
}
