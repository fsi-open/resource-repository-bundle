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
    public function let(Repository $repository): void
    {
        $this->beConstructedWith($repository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceRepositoryExtension::class);
    }

    public function it_is_twig_extension(): void
    {
        $this->shouldBeAnInstanceOf(AbstractExtension::class);
    }

    public function getMatchers(): array
    {
        return [
            'haveFunction' => function ($subject, $key) {
                $filter = static function ($function) use ($key): bool {
                    return $function instanceof TwigFunction && $function->getName() === $key;
                };

                return count(array_filter($subject, $filter)) > 0;
            }
        ];
    }
}
