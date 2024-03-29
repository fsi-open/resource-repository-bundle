# Resource Map

Resource map is nothing more than yaml. ``config/resource_map.yaml`` is default path to resource map.
You can change it via your application configuration:

```yaml
# config/packages/fsi_resource_repository.yml
---
fsi_resource_repository:
    map_path: %kernel.project_dir%/config/my_map_file_name.yaml
```

Example resource map:

```yaml
# config/resource_map.yaml

resources:
    type: group
    home_page:
        type: group
        header:
            type: text
            form_options:
                label: Page Header
            constraints:
                NotBlank: ~
                Length:
                    min: 2
                    max: 50
                    minMessage: "Your first name must be at least {{ limit }} characters length"
                    maxMessage: "Your first name cannot be longer than {{ limit }} characters length"
        content:
            type: textarea
            form_options:
                label: Page Content
```

There are following resource types available in bundle:

Available resource types
* ``text``
* ``integer``
* ``number``
* ``datetime``
* ``date``
* ``time``
* ``bool``
* ``url``
* ``email``
* [web_file (not available default)](file_upload.md)
* [fsi_ckeditor (deprecated, not available default)](fsi_ckeditor.md)
* [ckeditor (not available default)](ckeditor.md)

[Instruction how to add new resource type](adding_new_resource_type.md)

### Validation

Multiple constraints can be set to each resource type.
You can use all Symfony constraints just passing their short name (like NotBlank or Length) or custom one by passing full
class name (like FSi\Bundle\DemoBundle\Validator\Constraints\NotBlank)


[Basic Usage](basic_usage.md)
