<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Repository;

use FSi\Bundle\ResourceRepositoryBundle\Exception\ConfigurationException;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\ResourceInterface;
use Symfony\Component\Yaml\Yaml;

class MapBuilder
{
    /**
     * Template used to create constraint object
     */
    private const CONSTRAINT_CLASS = 'Symfony\\Component\\Validator\\Constraints\\%s';

    /**
     * @var array
     */
    protected $rawArray;

    /**
     * Parsed resources map
     *
     * @var array
     */
    protected $map;

    /**
     * Array that holds every single resource under unique key
     *
     * @var array
     */
    protected $resources = [];

    /**
     * @var string[]
     */
    protected $resourceTypes = [];

    public function __construct(string $mapPath, array $resourceTypes = [])
    {
        array_walk($resourceTypes, function (string $class, string $type): void {
            $this->resourceTypes[$type] = $class;
        });

        $this->map = true === file_exists($mapPath)
            ? $this->recursiveParseRawMap(Yaml::parse(file_get_contents($mapPath)))
            : []
        ;
    }

    /**
     * Return nested array where keys represent groups and values are resource types.
     *
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * Get resource definition by key.
     * It can return resource definition object or array if key represents resources group
     *
     * @param string $key
     * @return mixed
     */
    public function getResource(string $key)
    {
        return $this->resources[$key];
    }

    public function hasResource($key): bool
    {
        return array_key_exists($key, $this->resources);
    }

    /**
     * @param array $rawMap
     * @param null|string $parentPath
     * @throws \FSi\Bundle\ResourceRepositoryBundle\Exception\ConfigurationException
     * @return array
     */
    protected function recursiveParseRawMap(?array $rawMap = [], ?string $parentPath = null): array
    {
        $map = [];

        if (false === is_array($rawMap)) {
            return $map;
        }

        foreach ($rawMap as $key => $configuration) {
            $path = isset($parentPath) ? sprintf('%s.%s', $parentPath, $key) : $key;

            $this->validateConfiguration($configuration, $path);

            if ($configuration['type'] == 'group') {
                unset($configuration['type']);
                $map[$key] = $this->recursiveParseRawMap($configuration, $path);
                continue;
            }

            $this->validateResourceConfiguration($configuration);

            $resource = $this->createResource($configuration, $path);
            $this->addConstraints($resource, $configuration);
            $this->setFormOptions($resource, $configuration);

            $map[$key] = $resource;
            $this->resources[$path] = $map[$key];
        }

        return $map;
    }

    /**
     * @param array $configuration
     * @param string $path
     * @return ResourceInterface
     * @throws ConfigurationException
     */
    protected function createResource(array $configuration, string $path): ResourceInterface
    {
        $type = $configuration['type'];

        if (false === array_key_exists($type, $this->resourceTypes)) {
            throw new ConfigurationException(sprintf(
                '"%s" is not a valid resource type. Try one from: %s',
                $type,
                implode(', ', array_keys($this->resourceTypes))
            ));
        }

        $class = $this->resourceTypes[$type];

        return new $class($path);
    }

    protected function addConstraints(ResourceInterface $resource, array $configuration): void
    {
        if (isset($configuration['constraints'])) {
            $constraints = $configuration['constraints'];

            foreach ($constraints as $constraint => $constraintOptions) {
                if (!class_exists($constraint)) {
                    $constraint = sprintf(self::CONSTRAINT_CLASS, ucfirst($constraint));
                }

                $resource->addConstraint(new $constraint($constraintOptions));
            }
        }
    }

    protected function setFormOptions(ResourceInterface $resource, array $configuration): void
    {
        if (isset($configuration['form_options']) && is_array($configuration['form_options'])) {
            $resource->setFormOptions($configuration['form_options']);
        }
    }

    /**
     * @param array $configuration
     * @param string $path
     * @return void
     * @throws ConfigurationException
     */
    protected function validateConfiguration(array $configuration, string $path): void
    {
        if (strlen($path) > 255) {
            throw new ConfigurationException(sprintf(
                '"%s..." key is too long. Maximum key length is 255 characters',
                substr($path, 0, 32)
            ));
        }

        if (false === array_key_exists('type', $configuration)) {
            throw new ConfigurationException(sprintf(
                'Missing "type" declaration in "%s" element configuration',
                $path
            ));
        }

    }

    /**
     * @param array $configuration
     * @return void
     * @throws ConfigurationException
     */
    protected function validateResourceConfiguration(array $configuration): void
    {
        $validKeys = ['form_options', 'constraints'];
        foreach (array_keys($configuration) as $key) {
            if ($key === 'type' || in_array($key, $validKeys, true)) {
                continue;
            }

            throw new ConfigurationException(sprintf(
                '"%s" is not a valid resource type option. Try one from: %s',
                $key,
                implode(', ', $validKeys)
            ));
        }
    }
}
