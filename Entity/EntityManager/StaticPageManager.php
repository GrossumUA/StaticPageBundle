<?php

namespace Grossum\StaticPageBundle\Entity\EntityManager;

use Doctrine\Common\Persistence\ObjectManager;
use Grossum\CoreBundle\Entity\EntityTrait\SaveUpdateInManagerTrait;
use Grossum\StaticPageBundle\Entity\Repository\StaticPageRepository;

class StaticPageManager
{
    use SaveUpdateInManagerTrait;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return StaticPageRepository
     */
    private function getRepository()
    {
        return $this->objectManager->getRepository('GrossumStaticPageBundle:StaticPage');
    }
}
