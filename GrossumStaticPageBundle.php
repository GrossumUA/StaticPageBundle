<?php

namespace Grossum\StaticPageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sonata\CoreBundle\Form\FormHelper;
use Grossum\StaticPageBundle\Form\Type\StaticPageSelectorType;

class GrossumStaticPageBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $this->registerFormMapping();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->registerFormMapping();
    }

    /**
     * Register form mapping information.
     */
    public function registerFormMapping()
    {
        FormHelper::registerFormTypeMapping([
            'grossum_static_page_static_page_selector' => StaticPageSelectorType::class,
        ]);
    }
}
