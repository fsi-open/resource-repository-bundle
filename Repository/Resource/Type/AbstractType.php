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

abstract class AbstractType implements ResourceInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Constraint[]
     */
    protected $constraints;

    /**
     * @var array
     */
    protected $formOptions;

    /**
     * @var null|FormBuilderInterface
     */
    protected $formBuilder;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->constraints = [];
        $this->formOptions = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFormBuilder(FormFactoryInterface $factory): FormBuilderInterface
    {
        if (!isset($this->formBuilder)) {
            $this->formBuilder = $factory->createNamedBuilder(
                $this->getResourceProperty(),
                $this->getFormType(),
                null,
                $this->buildFormOptions()
            );
        }

        return $this->formBuilder;
    }

    public function addConstraint(Constraint $constraint): void
    {
        $this->constraints[] = $constraint;
    }

    public function setFormOptions(array $options): void
    {
        $this->formOptions = $options;
    }

    abstract public function getResourceProperty(): string;

    /**
     * Method should return form type used to modify resource.
     *
     * @return string
     */
    abstract protected function getFormType(): string;

    protected function buildFormOptions(): array
    {
        $options = array_merge(['required' => false, 'label' => false], $this->formOptions);

        if (count($this->constraints)) {
            $options = array_merge($options, ['constraints' => $this->constraints]);
        }

        return $options;
    }
}
