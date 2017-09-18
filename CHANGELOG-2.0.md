# List of changes in version 2.0

## DateTimeImmutable is returned for date and time value

To prevent the value from being modified, a `\DateTimeImmutable` instance is being
return for `date`, `time` and `datetime` types of resources.

## Removed deprecated interface

`FSi\Bundle\ResourceRepositoryBundle\Model\ResourceInterface` has been deleted
and replaced with `FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue`.

## Moved the Twig extension up a directory

`FSi\Bundle\ResourceRepositoryBundle\Twig\Extension\ResourceRepository` is now
`FSi\Bundle\ResourceRepositoryBundle\Twig\ResourceRepositoryExtension`.

## ResourceValue interface no longer returns self in setters

`FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue` no longer provides chain
functionality, since it was never used anyway.

## Dropped support for PHP below 7.1

To be able to fully utilize new functionality introduced in 7.1, we have decided 
to only support PHP versions equal or higher to it.
