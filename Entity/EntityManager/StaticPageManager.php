<?php

namespace Grossum\StaticPageBundle\Entity\EntityManager;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

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
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var BaseStaticPageRepository
     */
    private $repository;

    /**
     * @param ObjectManager $objectManager
     * @param string $staticPageClass
     */
    public function __construct(ObjectManager $objectManager, $staticPageClass)
    {
        $this->objectManager   = $objectManager;
        $this->staticPageClass = $staticPageClass;
    }

    /**
     * @return BaseStaticPageRepository
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->objectManager->getRepository($this->staticPageClass);
        }

        return $this->repository;
    }

    public function flush()
    {
        $this->objectManager->flush();
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
}
