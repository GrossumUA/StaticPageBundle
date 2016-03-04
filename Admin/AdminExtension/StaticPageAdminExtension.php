<?php

namespace Grossum\StaticPageBundle\Admin\AdminExtension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;

use Grossum\StaticPageBundle\Entity\EntityManager\StaticPageManager;

class StaticPageAdminExtension extends AdminExtension
{
    /**
     * @var StaticPageManager
     */
    protected $staticPageManager;

    /**
     * @param StaticPageManager $staticPageManager
     */
    public function __construct(StaticPageManager $staticPageManager)
    {
        $this->staticPageManager = $staticPageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate(AdminInterface $admin, $object)
    {
        $this->recoverTree();
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(AdminInterface $admin, $object)
    {
        $this->recoverTree();
    }

    /**
     * {@inheritdoc}
     */
    public function preRemove(AdminInterface $admin, $object)
    {
        $this->recoverTree();
    }

    protected function recoverTree()
    {
        $this->staticPageManager->getRepository()->recover();
    }
}
