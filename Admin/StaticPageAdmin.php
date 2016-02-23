<?php

namespace Grossum\StaticPageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class StaticPageAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'enabled',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.enabled',
                ]
            )
            ->add(
                'title',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.title',
                ]
            )
            ->add(
                'parent',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.parent',
                ]
            )
            ->add(
                'slug',
                null,
                [
                    'required' => false,
                    'label'    => 'grossum_static_page.admin.static_page.slug',
                ]
            )
            ->add(
                'body',
                CKEditorType::class,
                [
                    'required' => false,
                    'label'    => 'grossum_static_page.admin.static_page.body',
                ]
            )
            ->add(
                'position',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.position',
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier(
                'title',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.title',
                ]
            )
            ->addIdentifier(
                'slug',
                null,
                [
                    'required' => false,
                    'label'    => 'grossum_static_page.admin.static_page.slug',
                ]
            )
            ->add(
                'parent.title',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.parent',
                ]
            )
            ->add(
                'position',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.position',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'edit'   => [],
                        'delete' => []
                    ],
                ]
            );
    }
}
