<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository;
use FSi\Bundle\ResourceRepositoryBundle\Exception\EntityRepositoryException;
use FSi\Bundle\ResourceRepositoryBundle\Model\Resource as BaseResource;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\FSi\Bundle\ResourceRepositoryBundle\Doctrine\Resource;

class Resource extends BaseResource
{
}

class ResourceRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $em, ClassMetadata $class)
    {
        $class->name = Resource::class;
        $this->beConstructedWith($em, $class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResourceRepository::class);
    }

    function it_is_doctrine_entity_repository()
    {
        $this->shouldBeAnInstanceOf(EntityRepository::class);
    }

    function it_throw_exception_during_findBy_method()
    {
        $this->shouldThrow(
            new EntityRepositoryException('Method "findBy" is not supported in "FSiResourceRepository:Resource" entity repository')
        )->during('findBy', [[]]);
    }

    function it_throw_exception_during_findAll_method()
    {
        $this->shouldThrow(
            new EntityRepositoryException('Method "findAll" is not supported in "FSiResourceRepository:Resource" entity repository')
        )->during('findAll', []);
    }

    function it_throw_exception_during_findOneBy_method()
    {
        $this->shouldThrow(
            new EntityRepositoryException('Method "findOneBy" is not supported in "FSiResourceRepository:Resource" entity repository')
        )->during('findOneBy', [[]]);
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

    function it_adds_new_resource_value_entity(EntityManager $em, ResourceValue $resourceValue)
    {
        $em->persist($resourceValue)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->add($resourceValue);
    }

    function it_saves_new_resource_value_entity(EntityManager $em, ResourceValue $resourceValue)
    {
        $em->persist($resourceValue)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->save($resourceValue);
    }

    function it_removes_resource_value_entity(EntityManager $em, ResourceValue $resourceValue)
    {
        $em->remove($resourceValue)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->remove($resourceValue);
    }

    public function getMatchers()
    {
        return [
            'returnResourceWithKey' => function($subject, $key) {
                if (!$subject instanceof Resource) {
                    return false;
                }

                if ($subject->getKey() !== $key) {
                    return false;
                }

                return true;
            }
        ];
    }
}
