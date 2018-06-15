<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Repository;

use FSi\Bundle\ResourceRepositoryBundle\Exception\ConfigurationException;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\IntegerType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\Constraints\NotBlank;

class MapBuilderSpec extends ObjectBehavior
{
    protected $resources = ['text' => TextType::class, 'integer' => IntegerType::class];

    function let()
    {
        $this->beConstructedWith(
            __DIR__ . '/../../../../Fixtures/simple_valid_map.yml',
            $this->resources
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MapBuilder::class);
    }

    function it_should_have_valid_simple_map()
    {
        $this->getMap()->shouldHaveMap([
            'main_resource_group' => [
                'resource_block' => [
                    'resource_a' => TextType::class,
                    'resource_b' => TextType::class,
                    'resource_c' => TextType::class
                ]
            ]
        ]);
    }

    function it_should_return_text_type_object()
    {
        $this->getResource('main_resource_group.resource_block.resource_a')
            ->shouldReturnAnInstanceOf(TextType::class);
    }

    function it_should_return_false_if_resource_key_does_not_exists()
    {
        $this->hasResource('this.is.not.a.resource.key')->shouldReturn(false);
    }

    function it_should_throw_exception_when_group_does_not_have_type()
    {
        $this->shouldThrow(
            new ConfigurationException('Missing "type" declaration in "main_resource_group.resource_block" element configuration')
        )->during('__construct', [
                __DIR__ . '/../../../../Fixtures/simple_map_with_missing_group_type.yml',
                $this->resources
        ]);
    }

    function it_should_throw_exception_when_element_have_invalid_type()
    {
        $this->shouldThrow(
            new ConfigurationException('"this_is_not_a_valid_type" is not a valid resource type. Try one from: text, integer')
        )->during('__construct', [
                __DIR__ . '/../../../../Fixtures/simple_map_with_invalid_resource_type.yml',
                $this->resources
        ]);
    }

    function it_should_throw_exception_when_resource_path_is_longer_than_255_characters()
    {
        $this->shouldThrow(
            new ConfigurationException('"main_resource_group.this_is_long..." key is too long. Maximum key length is 255 characters')
        )->during('__construct', [
                __DIR__ . '/../../../../Fixtures/simple_map_with_too_long_path.yml',
                $this->resources
        ]);
    }

    function it_should_parse_empty_file_witht_resource_map()
    {
        $this->beConstructedWith(__DIR__ . '/../../../../Fixtures/empty_map.yml', $this->resources);
        $this->getMap()->shouldReturn([]);
    }

    function it_should_create_resource_with_validator()
    {
        $text = new TextType('resources.resource_text');
        $text->addConstraint(new NotBlank());

        $this->beConstructedWith(__DIR__ . '/../../../../Fixtures/simple_valid_map_with_validators.yml', $this->resources);
        $this->getResource('resources.resource_text')->shouldBeLike($text);
    }

    function it_should_create_resource_with_form_options()
    {
        $text = new TextType('resources.resource_text');
        $text->setFormOptions(['attr' => ['class' => 'class-name']]);

        $this->beConstructedWith(__DIR__ . '/../../../../Fixtures/simple_valid_map_with_form_options.yml', $this->resources);
        $this->getResource('resources.resource_text')->shouldBeLike($text);
    }

    function it_should_throw_exception_when_resource_type_have_invalid_option()
    {
        $this->shouldThrow(
            new ConfigurationException('"form-options" is not a valid resource type option. Try one from: form_options, constraints')
        )->during('__construct', [
                __DIR__ . '/../../../../Fixtures/simple_valid_map_with_invalid_type_options.yml',
                $this->resources
        ]);
    }

    public function getMatchers(): array
    {
        return [
            'haveMap' => function($map, $expectedMap) {
                $walker = function ($map, $expectedMap) use (&$walker) {
                    foreach ($map as $key => $element) {
                        if (!array_key_exists($key, $expectedMap)) {
                            return false;
                        }

                        if (!is_array($element)) {
                            if (get_class($element) !== $expectedMap[$key]) {
                                return false;
                            }
                        }

                        if (is_array($element)) {
                            if (!$walker($element, $expectedMap[$key])) {
                                return false;
                            }
                        }

                        return true;
                    }
                };

                return $walker($map, $expectedMap);
            },
        ];
    }
}
