<?php

namespace Grossum\StaticPageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GrossumStaticPageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $registeredBundles = $container->getParameter('kernel.bundles');

        if (!isset($registeredBundles['GrossumCoreBundle'])) {
            throw new LogicException('GrossumStaticPageBundle required GrossumCoreBundle');
        } elseif (!isset($registeredBundles['IvoryCKEditorBundle'])) {
            throw new LogicException('GrossumStaticPageBundle required IvoryCKEditorBundle');
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin.yml');
        $loader->load('classes.yml');
        $loader->load('services.yml');
    }
}
