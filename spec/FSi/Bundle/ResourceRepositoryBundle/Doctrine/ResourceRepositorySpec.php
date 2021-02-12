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
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use FSi\Bundle\ResourceRepositoryBundle\Tests\Entity\Resource;

class ResourceRepositorySpec extends ObjectBehavior
{
    public function let(EntityManager $em, ClassMetadata $class): void
    {
        $class->name = Resource::class;
        $this->beConstructedWith($em, $class);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceRepository::class);
    }

    public function it_is_doctrine_entity_repository(): void
    {
        $this->shouldBeAnInstanceOf(EntityRepository::class);
    }

    public function it_throw_exception_during_findBy_method(): void
    {
        $this->shouldThrow(
            new EntityRepositoryException(
                sprintf('Method "findBy" is not supported in "%s" entity repository', Resource::class)
            )
        )->during('findBy', [[]]);
    }

    public function it_throw_exception_during_findAll_method(): void
    {
        $this->shouldThrow(
            new EntityRepositoryException(
                sprintf('Method "findAll" is not supported in "%s" entity repository', Resource::class)
            )
        )->during('findAll', []);
    }

    public function it_throw_exception_during_findOneBy_method(): void
    {
        $this->shouldThrow(
            new EntityRepositoryException(
                sprintf('Method "findOneBy" is not supported in "%s" entity repository', Resource::class)
            )
        )->during('findOneBy', [[]]);
    }

    public function it_return_entity_even_if_it_not_exist_in_db(EntityManager $em): void
    {
        $em->find(Argument::any(), 'resources.resource_a', Argument::any(), Argument::any())->willReturn(null);
        $this->find('resources.resource_a')->shouldReturnResourceWithKey('resources.resource_a');
    }

    public function it_return_entity_in_get_method(EntityManager $em): void
    {
        $em->find(Argument::any(), 'resources.resource_a', Argument::any(), Argument::any())->willReturn(null);
        $this->get('resources.resource_a')->shouldReturnResourceWithKey('resources.resource_a');
    }

    public function it_adds_new_resource_value_entity(EntityManager $em, ResourceValue $resourceValue): void
    {
        $em->persist($resourceValue)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->add($resourceValue);
    }

    public function it_saves_new_resource_value_entity(EntityManager $em, ResourceValue $resourceValue): void
    {
        $em->persist($resourceValue)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->save($resourceValue);
    }

    public function it_removes_resource_value_entity(EntityManager $em, ResourceValue $resourceValue): void
    {
        $em->remove($resourceValue)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->remove($resourceValue);
    }

    public function getMatchers(): array
    {
        return [
            'returnResourceWithKey' => function ($subject, $key) {
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
