<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraint;

interface ResourceInterface
{
    public function getName(): string;

    /**
     * Return property that is used in Resource entity to store resource value.
     */
    public function getResourceProperty(): string;

    public function addConstraint(Constraint $constraint): void;

    /**
     * @param array<string, mixed> $options
     */
    public function setFormOptions(array $options): void;

    public function getFormBuilder(FormFactoryInterface $factory): FormBuilderInterface;
}
