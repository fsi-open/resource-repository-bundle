# Basic usage

## Accessing resources in PHP

All resources should be accessed via the ``FSi\Bundle\ResourceRepositoryBundle\Repository\Repository`` service.
**Important** it is not a Doctrine ORM repository!

### Example usage inside of a controller:

```php

declare(strict_types=1);

namespace FSi\Bundle\DemoBundle\Controller;

use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use Symfony\Component\HttpFoundation\Response;

final class DemoController
{
    private Repository $resourceRepository;

    // ... constructor

    public function __invoke(): Response
    {
        // get value
        $textResource = $this->resourceRepository->get('resources.resource_text');

        // set value
        $this->resourceRepository->set('resources.resource_text', 'some value');

        // return response
    }
}
```

## Modify resource value

To modify resource/resources you should use ``resource`` form type.

```php

declare(strict_types=1);

namespace FSi\Bundle\DemoBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FSi\Bundle\ResourceRepositoryBundle\Form\Type\ResourceType;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Repository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class DemoController
{
    private Repository $resourceRepository;
    private FormFactoryInterface $formFactory;
    private Environment $twig;

    // ... constructor

    public function __invoke(Request $request): Response
    {
        $resource = new FSiResource();
        $resource->setTextValue($this->resourceRepository->get('resources.resource_text'));

        $form = $this->formFactory->create(ResourceType::class, $resource, [
            'resource_key' => 'resources.resource_text'
        ]);

        $form->handleRequest($request);
        if (true === $form->isSubmitted() && true === $form->isValid()) {
            $this->resourceRepository->set('resources.resource_text', $resource->getTextValue());
        }

        return new Response(
            $this->twig->render(
                '@FSiCompanySite/Default/index.html.twig',
                ['form' => $form->createView()]
            )
        );
    }
}
```

## Display resource in twig

To display resources in Twig templates you can use ``get_resource`` and ``has_resource`` functions.

```twig
{# index.html.twig #}
{% if has_resource('resources.resource_text') %}
    Text content: {{ get_resource('resources.resource_text') }}
{% endif %}
```

### Default value

You can use second argument as a default value in case that resource is not filled.

```twig
{{ get_resource('resources.resource_text', 'in construction...') }}
```
