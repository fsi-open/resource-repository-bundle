<?php

namespace FSi\Bundle\ResourceRepositoryBundle\DataFixtures\Populator;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository as ResourceRepository;
use FSi\DoctrineExtensions\Translatable\TranslatableListener;
use Nelmio\Alice\Instances\Populator\Methods\MethodInterface;
use Nelmio\Alice\Fixtures\Fixture;

use AppBundle\Entity\Resource;

/**
 * @author Piotr Szymaszek <piotr.szymaszek@fsi.pl>
 */
class ResourcePopulator implements MethodInterface
{
    /**
     * @var ResourceRepository
     */
    private $resourceRepository;

    /**
     * @var TranslatableListener
     */
    private $translatableListener;

    public function __construct(
        ResourceRepository $resourceRepository,
        TranslatableListener $translatableListener
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->translatableListener = $translatableListener;
    }

    /**
     * {@inheritDoc}
     */
    public function canSet(Fixture $fixture, $object, $property, $value)
    {
        $isResource = $object instanceof Resource;
        if ($isResource) {
            // so no object with an empty ID is persisted
            $object->setKey($fixture->getName());
        }

        return $isResource;
    }

    /**
     * {@inheritDoc}
     */
    public function set(Fixture $fixture, $object, $property, $value)
    {
        $currentLocale = $this->translatableListener->getLocale();
        $locale = $this->extractLocale($fixture->getName());
        if ($locale) {
            $this->translatableListener->setLocale($locale);
        }
        $this->resourceRepository->set($property, $value);
        if ($currentLocale) {
            $this->translatableListener->setLocale($currentLocale);
        }
    }

    /**
     * Fixture name must end with '_{locale}' in order for this to work.
     * @param string $name
     * @return string
     */
    private function extractLocale($name)
    {
        $matches = [];
        $locale = null;
        if (preg_match('/_[a-z]{2}$/', $name, $matches)) {
            $locale = str_replace('_', '', reset($matches));
        }

        return $locale;
    }
}
