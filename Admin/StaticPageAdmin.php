<?php

namespace Grossum\StaticPageBundle\Admin;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
            ->add('enabled')
            ->add('title', TextType::class)
            ->add('parent')
            ->add(
                'slug',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'body',
                CKEditorType::class,
                [
                    'required' => false
                ]
            )
            ->add('position', IntegerType::class);
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
            ->addIdentifier('title')
            ->addIdentifier('slug')
            ->add(
                'parent.title',
                null,
                [
                    'label' => 'Parent'
                ]
            )
            ->add('position')
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'edit'   => [],
                        'delete' => []
                    ],
                    'label' => 'Actions'
                ]
            );
    }
}
