<?php

namespace Grossum\StaticPageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Grossum\StaticPageBundle\Entity\BaseStaticPage;
use Grossum\StaticPageBundle\Entity\EntityManager\StaticPageManager;

class StaticPageAdmin extends Admin
{
    /**
     * @var array
     */
    protected $formOptions = array(
        'cascade_validation' => true,
    );

    /**
     * @var StaticPageManager
     */
    protected $staticPageManager;

    /**
     * {@inheritdoc}
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes
            ->add('tree', 'tree')
            ->add('save-tree', 'save-tree', [], [], ['expose' => true]);
    }

    /**
     * @param string $context
     * @return QueryBuilder|ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        /* @var $query QueryBuilder */

        $query->andWhere($query->getRootAliases()[0] . '.parent IS NOT NULL');

        return $query;
    }

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
                'grossum_static_page_static_page_selector',
                [
                    'model_manager' => $this->getModelManager(),
                    'class'         => $this->getClass(),
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
                'enabled',
                null,
                [
                    'label' => 'grossum_static_page.admin.static_page.enabled',
                ]
            );
    }

    /**
     * @param StaticPageManager $staticPageManager
     */
    public function setManager(StaticPageManager $staticPageManager)
    {
        $this->staticPageManager = $staticPageManager;
    }

    /**
     * @param BaseStaticPage $object
     * @return void
     */
    public function preRemove($object)
    {
        $this->fixTreeIfNeeded($object);
    }

    /**
     * @param BaseStaticPage $object
     * @return void
     */
    public function postPersist($object)
    {
        $this->fixTreeIfNeeded($object);
    }

    /**
     * @param BaseStaticPage $object
     * @return void
     */
    public function prePersist($object)
    {
        $maxPosition = $this->staticPageManager->getRepository()->getMaxPosition();

        $object->setPosition($maxPosition + 1);
    }

    /**
     * @param BaseStaticPage $object
     * @return void
     */
    public function postUpdate($object)
    {
        $this->fixTreeIfNeeded($object);
    }

    /**
     * @param BaseStaticPage $staticPage
     * @return void
     */
    private function fixTreeIfNeeded(BaseStaticPage $staticPage)
    {
        $em = $this->modelManager->getEntityManager($staticPage);
        /* @var $em EntityManager */

        $repo = $this->staticPageManager->getRepository();

        $repo->verify();
        $repo->recover();
        $em->flush();
    }
}
