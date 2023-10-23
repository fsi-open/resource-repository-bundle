# CKEditor Wysiwyg

WYSIWYG (What you see is what you get) editor.
To use ``ckeditor`` resource type you need to register ``friendsofsymfony/ckeditor-bundle`` that provide ``ckeditor``
form type.

## 1. Composer
Add to composer.json following lines

```bash
"require": {
    "friendsofsymfony/ckeditor-bundle" : "^2.0"
}
```

## 2. Bundles

```php
// config/bundles.php
<?php

return [
    FOS\CKEditorBundle\FOSCKEditorBundle::class => ['all' => true],

    // FSiResourceRepositoryBundle must be after FOSCKEditorBundle
    FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle::class => ['all' => true]
];
```

Example:

```yaml
# config/resource_map.yaml

resources:
    type: group
    home_page:
        type: group
        content:
            type: ckeditor
            form_options:
                label: Content
```

To read about ckeditor form type options go to [FOSCKEditorBundle](https://github.com/FriendsOfSymfony/FOSCKEditorBundle/blob/master/docs/usage/config.rst)
