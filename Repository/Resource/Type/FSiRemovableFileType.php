<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use FSi\Bundle\DoctrineExtensionsBundle\Form\Type\FSi\RemovableFileType as FSiRemovableFileFormType;

class FSiRemovableFileType extends AbstractType
{
    public function getResourceProperty(): string
    {
        return 'fileValue';
    }

    protected function getFormType(): string
    {
        return FSiRemovableFileFormType::class;
    }

    protected function buildFormOptions(): array
    {
        $options = parent::buildFormOptions();

        if (isset($options['constraints'])) {
            $options['file_options'] = array_merge(
                isset($options['file_options']) ? $options['file_options'] : [],
                ['constraints' => $options['constraints']]
            );
            unset($options['constraints']);
        }

        return $options;
    }
}
