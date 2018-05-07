<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Twig;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use FSi\Bundle\ResourceRepositoryBundle\Twig\ResourceRepositoryExtension;
use PhpSpec\ObjectBehavior;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ResourceRepositoryExtensionSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResourceRepositoryExtension::class);
    }

    function it_is_twig_extension()
    {
        $this->shouldBeAnInstanceOf(AbstractExtension::class);
    }

    function it_have_fsi_resource_repository_name()
    {
        $this->getName()->shouldReturn('fsi_resource_repository');
    }

    public function getMatchers()
    {
        return [
            'haveFunction' => function($subject, $key) {
                $filter = function ($function) use ($key) {
                    return $function instanceof TwigFunction
                        && $function->getName() == $key
                    ;
                };

                return count(array_filter($subject, $filter)) > 0;
            }
        ];
    }
}
