# CKEditor Wysiwyg

WYSIWYG (What you see is what you get) editor.
To use ``ckeditor`` resource type you need to register ``egeloen/ckeditor-bundle`` that provide ``ckeditor``
form type.

## 1. Composer
Add to composer.json following lines

```
"require": {
    "egeloen/ckeditor-bundle" : "~2.5"
}
```

## 2. Application Kernel
 
Register bundle in AppKernel  
**IMPORTANT!!** make sure that ``FOS\CKEditorBundle\FOSCKEditorBundle()`` is registered
**before** ``FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle()``. In other way you will not be able
to use ckeditor resource type.

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        new FOS\CKEditorBundle\FOSCKEditorBundle(),

        // FSiResourceRepositoryBundle must be after FOSCKEditorBundle

        new FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle()
    );

    return $bundles;
}
```

Example:

```yaml
# app/config/resource_map.yml

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
