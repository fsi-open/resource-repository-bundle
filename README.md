# Resource Repository Bundle

Almost every single website have content that exist just in one place. For example text box at main page.
There is no problem if this text is static but what if site admin needs to modify it?
Then you should use ResourceRepositoryBundle that allows you to define resources in resource map and use them in Twig
templates or in controller. Resources are stored in database but you should not use them as normal Entity.
Resource is accessible only through ``Resource\Repository`` object that is registered as symfony2 service.

# Installation

## 1. Composer
Add to composer.json following lines

```
    "require": {
        "fsi/resource-repository-bundle": "0.9.*"
    },
```

Update dependencies

```
$ composer update
```

## 2. Application Kernel

Register new bundle in AppKernel

```php
// app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new FSi\Bundle\ResourceRepositoryBundle\FSiResourceRepositoryBundle()
            // ...
        );

        return $bundles;
    }
```

## 3. Resource Map

Create resource map file. (This file is required and you need to create it even if it will be empty for a while)

```
# app/config/resource_map.yml

```

By default resource map is loaded from ``app/config/resource_map.yml`` file but you can change
it via application configuration.

```
# app/config/config.yml

fsi_resource_repository:
    map_path: %kernel.root_dir%/config/my_map_file_name.yml
```

There are two kind of elements that can be defined in resource_map. ``group`` and ``resource``.
Each of them must have ``type`` key with some specific value.
Lets assume you want to have all resources under ``resources`` group.

```
# app/config/resource_map.yml

resources:
    type: group

```

Now when you have empty resource group its time to add at least one resource into it.

```
# app/config/resource_map.yml

resources:
    type: group
    resource_text:
        type: text
```

Of course you can also add another resource group under ``resources`` group

```
# app/config/resource_map.yml

resources:
    type: group
    resource_text:
        type: text
    resources_sub_group:
        type: group
        sub_resource_test:
            type: text
```

That's all folks :) 

# Usage

First of all you need to remember few simple rules

- You should never use Resource Entity repository.
- To get resource content you should use only ``fsi_resource_repository.repository`` service, like in following example:

```php

public fucntion indexAction()
{
    $this->get('fsi_resource_repository.repository')->get('resources.resource_text');
}

```
- To modify resource/resources you should use ``resource`` and ``resource_collection`` form types. 

```php
    // Single resource editor 
    public function indexAction(Request $request)
    {
        /**
         * Even if resources.resource_file does not exist in db resource entity repository will
         * return Entity\Resource object. Form types resource and resource_collection do not accept null
         * data. 
         */
        $resource = $this->getDoctrine()
            ->getRepository('FSiResourceRepositoryBundle:Resource')
            ->get('resources.resource_text');

        $form = $this->createForm('resource', $resource);

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $entity = $form->getData();
                
                $this->getDoctrine()->getManager()->persist($entity);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->render('@FSiCompanySite/Default/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    // Multiple resource editor
    public function indexAction(Request $request)
    {
        $form = $this->createForm('resource_collection', array(
            $this->getDoctrine()->getRepository('FSiResourceRepositoryBundle:Resource')->get('resources.resource_text'),
            $this->getDoctrine()->getRepository('FSiResourceRepositoryBundle:Resource')->get('resources.resource_integer'),
            $this->getDoctrine()->getRepository('FSiResourceRepositoryBundle:Resource')->get('resources.resource_datetime'),
        ));

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $data = $form->getData();
                foreach ($data as $entity) {
                    $this->getDoctrine()->getManager()->persist($entity);
                }

                $this->getDoctrine()->getManager()->flush();
            } else {
                var_dump($form->getErrors());
            }
        }

        return $this->render('@FSiCompanySite/Default/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
```

- Resource edit form label is always created from resource key with suffix ``.name``
To translate resource label with key ``resources.resource_text`` you need to create translation file with key
``resources.resource_text.name`` and proper translation.
- To access resources in Twig you should use ``get_resource`` and ``has_resource`` functions. 

```
{# index.html.twig #}
{% if has_resource('resources.resource_text') %}
    Text content: {{ get_resource('resources.resource_text') }}
{% endif %}

```

- Available resource types 
text  
integer  
number  
datetime  
date  
time  
bool  
file  
url  
email  
wysiwyg  

# Adding new resource types.

Adding new resource type is very easy at all.
First you need to create resource type class that implements ``ResourceInterface`` or extends ``AbstractType``

```php
<?php

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\Email;

class EmailType extends AbstractType
{
    // This will be added later
}
```

Ok now you need to decide witch field in database will be used to store data.
Here is a list of choices you have:

- textValue
- datetimeValue
- dateValue
- timeValue
- numberValue
- integerValue
- boolValue
- fileValue

For EmailType the best choice is probably ``textValue``

```php
<?php

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\Email;

class EmailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getResourceProperty()
    {
        return 'textValue';
    }
}
```

Now we need to decide form type that will be used to modify resource value. Remember that this must be a valid symfony2
form type.

```php
<?php

namespace FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\Email;

class EmailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getResourceProperty()
    {
        return 'textValue';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return 'email';
    }
}
```

Now the last thing is to create service with ``resource.type`` tag and ``email`` alias.

```
    <service id="fsi_resource_repository.resource.type.url" class="FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\EmailType">
        <tag name="resource.type" alias="email"/>
    </service>
```

From now we have ``email`` resource type that can be used in resource map.

