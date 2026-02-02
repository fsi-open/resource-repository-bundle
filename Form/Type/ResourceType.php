<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Form\Type;

use FSi\Bundle\ResourceRepositoryBundle\Exception\ResourceFormTypeException;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ResourceType extends AbstractType
{
    private MapBuilder $mapBuilder;
    private string $resourceClass;

    public function __construct(MapBuilder $mapBuilder, string $resourceClass)
    {
        $this->mapBuilder = $mapBuilder;
        $this->resourceClass = $resourceClass;
    }

    public function getName(): string
    {
        return 'resource';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => $this->resourceClass]);
        $resolver->setRequired(['resource_key']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (false === $this->mapBuilder->hasResource($options['resource_key'])) {
            throw new ResourceFormTypeException("\"{$options['resource_key']}\" is not a valid resource key");
        }

        $resource = $this->mapBuilder->getResource($options['resource_key']);
        $resourceFormBuilder = $resource->getFormBuilder($builder->getFormFactory());

        $builder->add($resourceFormBuilder);
    }
}
