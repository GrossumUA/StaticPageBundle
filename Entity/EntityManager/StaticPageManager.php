<?php

namespace Grossum\StaticPageBundle\Entity\EntityManager;

use Doctrine\ORM\EntityManager;

use Grossum\CoreBundle\Entity\EntityTrait\SaveUpdateInManagerTrait;
use Grossum\StaticPageBundle\Entity\BaseStaticPage;
use Grossum\StaticPageBundle\Entity\Repository\BaseStaticPageRepository;

class StaticPageManager
{
    use SaveUpdateInManagerTrait;

    /**
     * @var string
     */
    private $staticPageClass;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var BaseStaticPageRepository
     */
    private $repository;

    /**
     * @param EntityManager $entityManager
     * @param string $staticPageClass
     */
    public function __construct(EntityManager $entityManager, $staticPageClass)
    {
        $this->entityManager   = $entityManager;
        $this->staticPageClass = $staticPageClass;
    }

    /**
     * @return BaseStaticPageRepository
     */
    public function getRepository()
    {
        if (null === $this->repository) {
            $this->repository = $this->entityManager->getRepository($this->staticPageClass);
        }

        return $this->repository;
    }

    /**
     * @throws \Exception
     */
    public function flush()
    {
        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    /**
     * @param BaseStaticPage $entity
     * @return array
     */
    public function getAvailableParents($entity)
    {
        if (!$entity->getId()) {
            return $this->getRepository()->findAll();
        }

        $exceptThis = $this->getRepository()->getChildren($entity);
        $exceptThis[] = $entity;

        return $this->getRepository()->findAllExcept($exceptThis);
    }

    /**
     * @param array $tree
     * @return array|bool
     */
    public function updateAndVerifyTree(array $tree)
    {
        $root = $this->getRepository()->findRootStaticPage();

        foreach ($tree as $treeData) {
            if (isset($treeData['item_id']) && $treeData['item_id'] === BaseStaticPage::ROOT) {
                continue;
            }

            if (!isset($treeData['parent_id']) || !isset($treeData['id'])) {
                continue;
            }

            /**
             * @var BaseStaticPage $staticPage
             */
            $staticPage = $this->getRepository()->find($treeData['id']);
            $parentId = ($treeData['parent_id'] === BaseStaticPage::ROOT) ? $root->getId() : $treeData['parent_id'];
            $parentStaticPage = $this->getRepository()->find($parentId);

            $staticPage->setParent($parentStaticPage)
                ->setLft($treeData['left'])
                ->setRgt($treeData['right']);
        }

        return $this->getRepository()->verify();
    }
}
