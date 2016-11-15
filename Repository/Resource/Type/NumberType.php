<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\Extension\Core\Type\NumberType as NumberFormType;

class NumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getResourceProperty()
    {
        return 'numberValue';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return NumberFormType::class;
    }

    protected function buildFormOptions()
    {
        $options = parent::buildFormOptions();

        $options = array_merge(
            [
                'precision' => 4
            ],
            $options
        );

        return $options;
    }
}
