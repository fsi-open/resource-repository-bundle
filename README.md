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
        "fsi/resource-repository-bundle": "1.0.*@dev"
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

Each resource can have own validators to prevent saving invalid data. Just like in following example:

```
resources:
    type: group
    resource_text:
        type: text
        constraints:
            NotBlank: ~
```

### 4. Entity

Create entity that extends from BaseResource mapped superclass.

```php
<?php

namespace FSi\Bundle\DemoBundle\Entity;

use FSi\Bundle\ResourceRepositoryBundle\Model\Resource as BaseResource;

class Resource extends BaseResource
{
}
```

### 5. Update db schema

Update your database schema

```
$ php app/console doctrine:schema:update --force
```

That's all folks :) 

# Usage

First of all you need to remember few simple rules

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
        $resource = $this->getDoctrine()
            ->getRepository('FSiResourceRepositoryBundle:Resource')
            ->get('resources.resource_text');

        $form = $this->createForm('resource', $resource, array(
            'resource_key' => 'resources.resource_text'
        ));

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
```

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
url  
email    

# Adding new resource types.

Adding new resource type is very easy at all.
First you need to create resource type class that implements ``ResourceInterface`` or extends ``AbstractType``

```php
<?php

namespace FSi\Bundle\DemoBundle\Repository\Resource\Type;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\AbstractType;
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

For EmailType the best choice is probably ``textValue``

```php
<?php

namespace FSi\Bundle\DemoBundle\Repository\Resource\Type;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\AbstractType;
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

namespace FSi\Bundle\DemoBundle\Repository\Resource\Type;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\AbstractType;
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
    <service id="fsi_demo_bundle.resource.type.url" class="FSi\Bundle\DemoBundle\Repository\Resource\Type\EmailType">
        <tag name="resource.type" alias="email"/>
    </service>
```

From now we have ``email`` resource type that can be used in resource map.

