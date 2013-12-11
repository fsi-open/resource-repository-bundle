# Resource Repository Bundle

Almost every single website have content that exist just in one place. For example text box at main page.
There is no problem if this text is static but what if site admin needs to modify it?
Then you should use ResourceRepositoryBundle that allows you to define resources in resource map and use them in Twig
templates or in controller. Resources are stored in database but you should not use them as normal Entity.
Resource is accessible only through ``Resource\Repository`` object that is registered as Symfony2 service.

Build Status:  
[![Build Status](https://travis-ci.org/fsi-open/resource-repository-bundle.png?branch=master)](https://travis-ci.org/fsi-open/resource-repository-bundle) - Master  
[![Build Status](https://travis-ci.org/fsi-open/resource-repository-bundle.png?branch=1.0)](https://travis-ci.org/fsi-open/resource-repository-bundle) - 1.0  

[![Latest Stable Version](https://poser.pugx.org/fsi/resource-repository-bundle/v/stable.png)](https://packagist.org/packages/fsi/resource-repository-bundle)


Documentation:

* [Installation](Resources/docs/installation.md)
* [Resource Map](Resources/docs/resource_map.md)
* [Basic Usage](Resources/docs/basic_usage.md)
* [File Upload](Resources/docs/file_upload.md)
* [CKEditor](Resources/docs/fsi_ckeditor.md)
* [Adding new resource type](Resources/docs/adding_new_resource_type.md)
