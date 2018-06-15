# Upgrade from versions 1.x to 2.0

## Do not use deleted resource interface

`FSi\Bundle\ResourceRepositoryBundle\Model\ResourceInterface` has been deleted,
use `FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue` instead.

## Upgrade to PHP 7.1 or higher

In order to use this bundle, you will need PHP 7.1 or higher.

## Do not use deleted entity

Class `FSi\Bundle\ResourceRepositoryBundle\Entity\ResourceRepository` has been
replaced with `FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository`.

## Do not use removed *.class container parameters

Do not use any of these parameters:

- `fsi_resource_repository.resource.value.repository.class`
- `fsi_resource_repository.resource.map_builder.class`
- `fsi_resource_repository.resource.repository.class`
- `fsi_resource_repository.twig.extension.resource_repository.class`
- `fsi_resource_repository.form.type.resource.class`
- `fsi_resource_repository.form.type.resource_collection.class`
