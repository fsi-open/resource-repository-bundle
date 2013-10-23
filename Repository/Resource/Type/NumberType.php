<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

class NumberType extends AbstractType
{
    /**
     * @var \Symfony\Component\Form\FormBuilder
     */
    protected $formBulder;

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
        return 'number';
    }

    protected function buildFormOptions()
    {
        $options = parent::buildFormOptions();

        $options = array_merge(
            $options,
            array(
                'precision' => 4
            )
        );

        return $options;
    }
}