# Resource Repository Bundle

This bundle provides an easy and extendible way of creating various editable resources.
Be it simple or formatted text, an image, a PDF file or a number value, you can
use one of the predefined types to handle it's database storage and displaying in
template. Should you require to, you can define your own types.

Basically, this bundle exists so you do not have to create dedicated entities for
simple content.

In order to access and modify said resources, you will have to use the [Repository/Repository](https://github.com/fsi-open/resource-repository-bundle/blob/master/Repository/Repository.php)
class (registered as a service). It will automatically fetch, save and handle the values conversion.

For displaying the values in templates, the bundle is integrated with Twig templating
language.

All of the above are described in detail in the documentation linked below.

Build Status:  
[![Build Status](https://travis-ci.org/fsi-open/resource-repository-bundle.png?branch=master)](https://travis-ci.org/fsi-open/resource-repository-bundle) - Master  
[![Build Status](https://travis-ci.org/fsi-open/resource-repository-bundle.png?branch=1.0)](https://travis-ci.org/fsi-open/resource-repository-bundle) - 1.0  

[![Latest Stable Version](https://poser.pugx.org/fsi/resource-repository-bundle/v/stable.png)](https://packagist.org/packages/fsi/resource-repository-bundle)

Code quality:
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/fsi-open/resource-repository-bundle/badges/quality-score.png?s=d40261524da1024a92e98b410d97a6568745b06a)](https://scrutinizer-ci.com/g/fsi-open/resource-repository-bundle/)

Documentation:

* [Installation](Resources/docs/installation.md)
* [Resource Map](Resources/docs/resource_map.md)
* [Basic Usage](Resources/docs/basic_usage.md)
* [File Upload](Resources/docs/file_upload.md)
* [CKEditor](Resources/docs/ckeditor.md)
* [Adding new resource type](Resources/docs/adding_new_resource_type.md)
