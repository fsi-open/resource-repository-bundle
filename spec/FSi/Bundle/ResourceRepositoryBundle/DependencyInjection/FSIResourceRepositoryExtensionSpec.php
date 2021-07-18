<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\DependencyInjection;

use FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\FSIResourceRepositoryExtension;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValueRepository;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use FSi\Bundle\ResourceRepositoryBundle\Tests\Entity\Resource;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class FSIResourceRepositoryExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FSIResourceRepositoryExtension::class);
    }

    public function it_should_have_a_valid_alias(): void
    {
        $this->getAlias()->shouldReturn('fsi_resource_repository');
    }

    public function it_should_add_resource_map_parameter_to_container(ContainerBuilder $builder): void
    {
        $builder->hasExtension(Argument::type('string'))->willReturn(false);
        if (method_exists(ContainerBuilder::class, 'fileExists')) {
            $builder->fileExists(Argument::type('string'))->willReturn(true);
        } else {
            $builder->addResource(Argument::type(FileResource::class))->shouldBeCalled();
        }
        $builder->setDefinition(Argument::type('string'), Argument::type(Definition::class))->shouldBeCalled();

        $builder->setParameter('fsi_resource_repository.resource.map_path', '%kernel.project_dir%/config/resource_map.yml')
            ->shouldBeCalled();
        $builder->setParameter('fsi_resource_repository.resource.value.class', Resource::class)->shouldBeCalled();

        $builder->setAlias('fsi_resource_repository.map_builder', Argument::type(Alias::class))->shouldBeCalled();
        $builder->setAlias(MapBuilder::class, Argument::type(Alias::class))->shouldBeCalled();
        $builder->setAlias('fsi_resource_repository.entity.repository', Argument::type(Alias::class))->shouldBeCalled();
        $builder->setAlias(ResourceValueRepository::class, Argument::type(Alias::class))->shouldBeCalled();
        $builder->setAlias('fsi_resource_repository.repository', Argument::type(Alias::class))->shouldBeCalled();
        $builder->setAlias(Repository::class, Argument::type(Alias::class))->shouldBeCalled();
        if (true === method_exists(ContainerBuilder::class, 'removeBindings')) {
            $builder->removeBindings(Argument::type('string'))->shouldBeCalled();
        }

        $this->load([['db_driver' => 'orm', 'resource_class' => Resource::class]], $builder);
    }
}
