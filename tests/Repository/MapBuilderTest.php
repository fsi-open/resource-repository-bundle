<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\FSi\Bundle\ResourceRepositoryBundle\Repository;

use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\IntegerType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PHPUnit\Framework\TestCase;

final class MapBuilderTest extends TestCase
{
    public function testNonExistantMap(): void
    {
        self::assertCount(0, (new MapBuilder('non existant path'))->getMap());
    }

    public function testExistingMap(): void
    {
        $mapBuilder = new MapBuilder(
            __DIR__ . '/../../spec/Fixtures/simple_valid_map.yml',
            ['text' => TextType::class, 'integer' => IntegerType::class]
        );

        self::assertCount(1, $mapBuilder->getMap());
    }
}
