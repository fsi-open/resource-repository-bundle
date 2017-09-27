# List of changes in version 2.0

## DateTimeImmutable is returned for datetime, date and time values

These values now require and return an instance of `DateTimeImmutable`. To accomodate
this change the database mappings for `FSi\Bundle\ResourceRepositoryBundle\Model\Resource`
have been changed to immutable, so the conversion is handled by Doctrine.

## Removed deprecated interface

`FSi\Bundle\ResourceRepositoryBundle\Model\ResourceInterface` has been deleted
and replaced with `FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue`.

## Moved the Twig extension up a directory

`FSi\Bundle\ResourceRepositoryBundle\Twig\Extension\ResourceRepository` is now
`FSi\Bundle\ResourceRepositoryBundle\Twig\ResourceRepositoryExtension`.

## ResourceValue interface no longer returns self in setters

`FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue` no longer provides chained
setters functionality, since it was never used anyway.

## Dropped support for PHP below 7.1

To be able to fully utilize new functionality introduced in 7.1, we have decided 
to only support PHP versions equal or higher to it.

## Removed deprecated entity

Class `FSi\Bundle\ResourceRepositoryBundle\Entity\ResourceRepository` has been
removed due to being deprecated.
