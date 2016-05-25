Static Page Bundle
==================

[![Latest Stable Version](https://poser.pugx.org/grossum/static-page-bundle/v/stable)](https://packagist.org/packages/grossum/static-page-bundle) [![Total Downloads](https://poser.pugx.org/grossum/static-page-bundle/downloads)](https://packagist.org/packages/grossum/static-page-bundle) [![Latest Unstable Version](https://poser.pugx.org/grossum/static-page-bundle/v/unstable)](https://packagist.org/packages/grossum/static-page-bundle) [![License](https://poser.pugx.org/grossum/static-page-bundle/license)](https://packagist.org/packages/grossum/static-page-bundle)

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require grossum/static-page-bundle "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new CoopTilleuls\Bundle\CKEditorSonataMediaBundle\CoopTilleulsCKEditorSonataMediaBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Grossum\StaticPageBundle\GrossumStaticPageBundle(),
        );

        // ...
    }

    // ...
}
```
