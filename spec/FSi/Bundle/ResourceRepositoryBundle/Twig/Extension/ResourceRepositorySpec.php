<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Twig\Extension;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceRepositorySpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Twig\Extension\ResourceRepository');
    }

    function it_is_twig_extension()
    {
        $this->shouldBeAnInstanceOf('Twig_Extension');
    }

    function it_have_fsi_resource_repository_name()
    {
        $this->getName()->shouldReturn('fsi_resource_repository');
    }

    function it_have_has_resource_function()
    {
        $this->getFunctions()->shouldhaveFunction('has_resource');
    }

    function it_have_get_resource_function()
    {
        $this->getFunctions()->shouldhaveFunction('get_resource');
    }

    function it_return_false_when_resource_does_not_exist_in_repository(Repository $repository)
    {
        $repository->get('resources.resource_a')->willReturn(null);

        $this->hasResource('resources.resource_a')->shouldReturn(false);
    }

    function it_return_true_when_resource_exist_in_repository(Repository $repository)
    {
        $repository->get('resources.resource_a')->willReturn('test');

        $this->hasResource('resources.resource_a')->shouldReturn(true);
    }

    function it_return_value_for_key_from_repository(Repository $repository)
    {
        $repository->get('resources.resource_a')->willReturn('resource_value');

        $this->getResource('resources.resource_a')->shouldReturn('resource_value');
    }

    function it_return_default_if_value_not_exists(Repository $repository)
    {
        $repository->get('resources.resource_a')->willReturn(null);

        $this->getResource('resources.resource_a', 'my_default')->shouldReturn('my_default');
    }

    public function getMatchers()
    {
        return [
            'haveFunction' => function($subject, $key) {
                foreach ($subject as $function) {
                    if ($function instanceof \Twig_SimpleFunction) {
                        if ($function->getName() == $key) {
                            return true;
                        }
                    }
                }

                return false;
            }
        ];
    }
}
