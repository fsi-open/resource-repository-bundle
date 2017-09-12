<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class FSIResourceRepositoryExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\DependencyInjection\FSIResourceRepositoryExtension');
    }

    function it_should_have_a_valid_alias()
    {
        $this->getAlias()->shouldReturn('fsi_resource_repository');
    }

    function it_should_add_resource_map_parameter_to_container(ContainerBuilder $builder, ParameterBagInterface $parameterBag)
    {
        $builder->hasExtension(Argument::type('string'))->willReturn(false);
        if (method_exists('Symfony\Component\DependencyInjection\ContainerBuilder', 'fileExists')) {
            $builder->fileExists(Argument::type('string'))->willReturn(true);
        } else {
            $builder->addResource(Argument::type('\Symfony\Component\Config\Resource\FileResource'))->shouldBeCalled();
        }
        $builder->setDefinition(Argument::type('string'), Argument::type('Symfony\Component\DependencyInjection\Definition'))->shouldBeCalled();
        $builder->getParameterBag()->shouldBeCalled()->willReturn($parameterBag);

        $builder->setParameter('fsi_resource_repository.resource.map_path', '%kernel.root_dir%/config/resource_map.yml')->shouldBeCalled();
        $builder->setParameter('fsi_resource_repository.resource.value.class', 'FSi\DemoBundle\Entity\Resource')->shouldBeCalled();

        $builder->setAlias('fsi_resource_repository.map_builder', Argument::type('Symfony\Component\DependencyInjection\Alias'))->shouldBeCalled();
        $builder->setAlias('fsi_resource_repository.entity.repository', Argument::type('Symfony\Component\DependencyInjection\Alias'))->shouldBeCalled();
        $builder->setAlias('fsi_resource_repository.repository', Argument::type('Symfony\Component\DependencyInjection\Alias'))->shouldBeCalled();

        $this->load([
            0 => [
                'db_driver' => 'orm',
                'resource_class' => 'FSi\DemoBundle\Entity\Resource'
            ]
        ], $builder);
    }
}
