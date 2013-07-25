<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Entity\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use FSi\Bundle\ResourceRepositoryBundle\Entity\Resource;
use FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceSpec extends ObjectBehavior
{
    function let(EntityManager $em, ClassMetadata $class)
    {
        $this->beConstructedWith($em, $class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Entity\Repository\Resource');
    }

    function it_is_doctrine_entity_repository()
    {
        $this->shouldBeAnInstanceOf('Doctrine\ORM\EntityRepository');
    }

    function it_throw_exception_during_findBy_method()
    {
        $this->shouldThrow(
            new EntityRepositoryException('Method "findBy" is not supported in "FSiResourceRepository:Resource" entity repository')
        )->during('findBy', array(array()));
    }

    function it_throw_exception_during_findAll_method()
    {
        $this->shouldThrow(
            new EntityRepositoryException('Method "findAll" is not supported in "FSiResourceRepository:Resource" entity repository')
        )->during('findAll', array());
    }

    function it_throw_exception_during_findOneBy_method()
    {
        $this->shouldThrow(
            new EntityRepositoryException('Method "findOneBy" is not supported in "FSiResourceRepository:Resource" entity repository')
        )->during('findOneBy', array(array()));
    }

    function it_return_entity_even_if_it_not_exist_in_db(EntityManager $em)
    {
        $em->find(Argument::any(), 'resources.resource_a', Argument::any(), Argument::any())->willReturn(null);
        $this->find('resources.resource_a')->shouldReturnResourceWithKey('resources.resource_a');
    }

    function it_return_entity_in_get_method(EntityManager $em)
    {
        $em->find(Argument::any(), 'resources.resource_a', Argument::any(), Argument::any())->willReturn(null);
        $this->get('resources.resource_a')->shouldReturnResourceWithKey('resources.resource_a');
    }

    public function getMatchers()
    {
        return array(
            'returnResourceWithKey' => function($subject, $key) {
                if (!$subject instanceof Resource) {
                    return false;
                }

                if ($subject->getKey() !== $key) {
                    return false;
                }

                return true;
            }
        );
    }
}
