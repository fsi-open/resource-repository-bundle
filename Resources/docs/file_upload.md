# File Upload

To use file as a resource type you need to add the [Files](https://github.com/fsi-open/files)
library to your application.

## 1. Composer

The following command will add the bundle to your `composer.json`:

```bash
composer require fsi/files
```

## 2. Application Kernel

Now, register the bundle in `bundles.php`.
**IMPORTANT!!** make sure that ``FSi\Component\Files\Integration\Symfony\FilesBundle`` is registered
**before** ``FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle``. Otherwise you will not be able
to use the file type resource.

```php
// config/bundles.php
<?php

return [
    // ... packages required by FilesBundle
    FSi\Component\Files\Integration\Symfony\FilesBundle::class => ['all' => true],

    // FSiResourceRepositoryBundle must be after FilesBundle
    FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle::class => ['all' => true]
];
```

## 3. Create or modify the resource entity

Now you need to change the extended class of your [Resource Entity](installation.md#3-create-entity) from
``FSi\Bundle\ResourceRepositoryBundle\Model\Resource`` to ``FSi\Bundle\ResourceRepositoryBundle\Model\ResourceWebFile``

This is how your Resource class should look now:

```php
<?php

declare(strict_types=1);

namespace FSi\Bundle\DemoBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceWebFile;

// You can use whatever drive you want for mapping
#[Entity(repositoryClass: "FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository"]
#[Table(name: "fsi_resource")]
class Resource extends ResourceWebFile
{
}
```

## 4. Update the database schema

Update your database schema forcefully:

```bash
$ php bin/console doctrine:schema:update --force
```

or via migrations:

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate -n
```

And now you should be able to use the new ``web_file`` resource type in your [Resource Map](resource_map.md).
See the [related documentation](https://github.com/fsi-open/files/blob/master/doc/usage.md#form) on how to use it.

Example:

```yaml
# config/resource_map.yaml

resources:
    type: group
    home_page:
        type: group
        terms_of_service:
            type: web_file
            form_options:
                label: Terms of service
            constraints:
                FSi\Component\Files\Integration\Symfony\Validator\Constraint\UploadedWebFile:
                    mimeTypes: ["application/pdf"]
        header:
            type: web_file
            form_options:
                label: Header background
                image: true
            constraints:
                FSi\Component\Files\Integration\Symfony\Validator\Constraint\UploadedImage:
                    maxWidth: 1650
                    maxHeight: 600
        advertisement:
            type: web_file
            form_options:
                label: Advertisement
                image: true
                removable: true
                constraints:
                    FSi\Component\Files\Integration\Symfony\Validator\Constraint\UploadedImage:
                        maxWidth: 400
                        maxHeight: 500
```
