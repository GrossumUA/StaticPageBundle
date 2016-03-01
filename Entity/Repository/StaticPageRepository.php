<?php

namespace Grossum\StaticPageBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Grossum\StaticPageBundle\Entity\BaseStaticPage;

class StaticPageRepository extends EntityRepository
{
    /**
     * @return BaseStaticPage[]
     */
    public function findAllEnabled()
    {
        return $this->findBy(['enabled' => true]);
    }
}
