<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Form\Extension\Core\Type\UrlType as UrlFormType;

class UrlType extends AbstractType
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->constraints[] = new Url();
    }

    public function getResourceProperty(): string
    {
        return 'textValue';
    }

    protected function getFormType(): string
    {
        return UrlFormType::class;
    }
}
