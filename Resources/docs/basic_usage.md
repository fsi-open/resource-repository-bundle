# Basic usage

First of all you need to remember few simple rules

## Get resource object in controller

To get resource content you should use only ``fsi_resource_repository.repository`` service,
like in following example:

> **Important** - fsi_resource_repository.repository is not a Doctrine ORM repository!
> It's instance of ``FSi\Bundle\ResourceRepositoryBundle\Repository\Repository`` class

```php

public function indexAction()
{
    $this->get('fsi_resource_repository.repository')->get('resources.resource_text');
}

```

## Modify resource value

To modify resource/resources you should use ``resource`` form type.

```php
// Single resource editor
public function indexAction(Request $request)
{
    $resource = $this->get('fsi_resource_repository.entity.repository')
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

## Display resource in twig

Display resources in Twig you should use ``get_resource`` and ``has_resource`` functions.

```
{# index.html.twig #}
{% if has_resource('resources.resource_text') %}
    Text content: {{ get_resource('resources.resource_text') }}
{% endif %}
```