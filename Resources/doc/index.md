Getting Started With GrossumStaticPageBundle
==================================

### Create your StaticPage class

##### yaml

If you use yml to configure Doctrine you must add two files. The Entity and the orm.yml:

```php
<?php
// src/Application/Grossum/StaticPageBundle/Entity/StaticPage.php

namespace Application\Grossum\StaticPageBundle\Entity;

use Grossum\StaticPageBundle\Entity\StaticPage as BaseStaticPage;

class StaticPage extends BaseStaticPage
{
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```
```yaml
# src/Application/Grossum/StaticPageBundle/Resources/config/doctrine/StaticPage.orm.yml
Application\Grossum\StaticPageBundle\StaticPage:
    type:  entity
    table: static_page
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

### Update config

```yml
# app/config/config.yml
stof_doctrine_extensions:
    default_locale: %locale%
    orm:
        default:
            sluggable:     true
            timestampable: true
```
