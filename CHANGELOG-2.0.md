# List of changes in version 2.0

## DateTimeImmutable is returned for date and time value

To prevent the value from being modified, a `\DateTimeImmutable` instance is being
return for `date` and `time` types of resources.

## Removed deprecated interface

`FSi\Bundle\ResourceRepositoryBundle\Model\ResourceInterface` has been deleted
and replaced with `FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue`.
