<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Validator\Constraints\Email;

class EmailType extends AbstractType
{
    /**
     * @var \Symfony\Component\Form\FormBuilder
     */
    protected $formBulder;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->constraints[] = new Email();
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceProperty()
    {
        return 'textValue';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return 'email';
    }
}