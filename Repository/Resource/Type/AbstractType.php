<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

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
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->constraints = array();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder(FormFactoryInterface $factory)
    {
        if (!isset($this->formBulder)) {
            $this->formBulder = $factory->createNamedBuilder(
                $this->getResourceProperty(),
                $this->getFormType(),
                null,
                $this->buildFormOptions()
            );
        }

        return $this->formBulder;
    }

    /**
     * {@inheritdoc}
     */
    public function addConstraint(Constraint $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getResourceProperty();

    /**
     * Method should return form type used to modify resource.
     *
     * @return string
     */
    abstract protected function getFormType();

    /**
     * @return array
     */
    protected function buildFormOptions()
    {
        $options = array(
            'required' => false,
            'label' => false,
        );

        if (count($this->constraints)) {
            $options = array_merge(
                $options,
                array(
                    'constraints' => $this->constraints
                )
            );
        }

        return $options;
    }
}