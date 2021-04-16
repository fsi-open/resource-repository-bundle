<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Twig;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ResourceRepositoryExtension extends AbstractExtension
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'has_resource',
                fn (string $key): bool => null !== $this->repository->get($key)
            ),
            new TwigFunction('get_resource', function (string $key, $default = null) {
                $value = $this->repository->get($key);
                return null !== $value ? $value : $default;
            })
        ];
    }
}
