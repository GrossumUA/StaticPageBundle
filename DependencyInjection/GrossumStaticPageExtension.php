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
     * @var array
     */
    protected $requiredBundles = [
        'GrossumCoreBundle',
        'IvoryCKEditorBundle'
    ];

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $registeredBundles = $container->getParameter('kernel.bundles');

        foreach ($this->requiredBundles as $requiredBundle) {
            if (!isset($registeredBundles[$requiredBundle])) {
                throw new LogicException(sprintf('GrossumStaticPageBundle required %s', $requiredBundle));
            }
        }

        $container->setParameter('grossum_static_page.entity.static_page.class', $config['class']['static_page']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('admin.yml');
        $loader->load('classes.yml');
        $loader->load('services.yml');
    }
}
