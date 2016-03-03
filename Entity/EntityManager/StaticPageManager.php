<?php

namespace Grossum\StaticPageBundle\Entity\EntityManager;

use Doctrine\Common\Persistence\ObjectManager;

use Grossum\CoreBundle\Entity\EntityTrait\SaveUpdateInManagerTrait;
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
        if (null === $this->repository) {
            $this->repository = $this->objectManager->getRepository($this->staticPageClass);
        }

        return $this->repository;
    }
}
