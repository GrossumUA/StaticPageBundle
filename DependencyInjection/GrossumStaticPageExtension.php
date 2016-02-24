<?php

namespace Grossum\StaticPageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

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

        $container->setParameter('grossum_static_page.entity.static_page.class', $config['class']['static_page']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin.yml');
        $loader->load('classes.yml');
        $loader->load('services.yml');

        $this->registerDoctrineMapping($config);
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['class']['static_page'], 'mapOneToMany', array(
            'fieldName'     => 'children',
            'targetEntity'  => $config['class']['static_page'],
            'mappedBy'      => 'parent',
            'orphanRemoval' => false,
        ));

        $collector->addAssociation($config['class']['static_page'], 'mapManyToOne', array(
            'fieldName'     => 'parent',
            'targetEntity'  => $config['class']['static_page'],
            'mappedBy'      => null,
            'inversedBy'    => 'children',
            'joinColumns'   => array(
                array(
                    'name'                 => 'parent_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));
    }
}
