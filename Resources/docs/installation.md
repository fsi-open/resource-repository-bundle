# Installation

## 1. Composer
Add to composer.json following lines

```
"require": {
    "fsi/resource-repository-bundle": "^3.0"
}
```

## 2. Register bundle

Register bundle in bundles.php

```php
// config/bundles.php
<?php

return [
    FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle::class => ['all' => true]
];
```

### 3. Create entity

Create entity that extends base resource model

```php
<?php

declare(strict_types);

namespace FSi\Bundle\DemoBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use FSi\Bundle\ResourceRepositoryBundle\Model\Resource as BaseResource;

#[Entity(repositoryClass: "FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository"]
#[Table(name: "fsi_resource")]
class Resource extends BaseResource
{
}
```

### 4. Set resource class in application config

```
# config/packages/fsi_resource_repository.yml

---
fsi_resource_repository:
    db_driver: orm
    resource_class: FSi\Bundle\DemoBundle\Entity\Resource
```

**Heads up!** Although ``db_driver`` option has its default value ``orm``, you should put it in your
config file to prevent problems with future releases of fsi/resource-repository-bundle.

### 5. Update database schema

Update your database schema forcefully:

```bash
$ php bin/console doctrine:schema:update --force
```

or via migrations:

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate -n
```

Now you are ready to create [Resource Map](resource_map.md)
