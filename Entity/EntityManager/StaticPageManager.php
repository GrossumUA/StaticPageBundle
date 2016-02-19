<?php

namespace Grossum\StaticPageBundle\Entity\EntityManager;

use Doctrine\Common\Persistence\ObjectManager;

use Grossum\CoreBundle\Entity\EntityTrait\SaveUpdateInManagerTrait;
use Grossum\StaticPageBundle\Entity\Repository\StaticPageRepository;

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
     * @var StaticPageRepository
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
     * @return StaticPageRepository
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->objectManager->getRepository($this->staticPageClass);
        }

        return $this->repository;
    }
}
