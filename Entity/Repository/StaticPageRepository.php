<?php

namespace Grossum\StaticPageBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Grossum\StaticPageBundle\Entity\StaticPage;

class StaticPageRepository extends EntityRepository
{
    /**
     * @return StaticPage[]
     */
    public function findAllEnabled()
    {
        return $this->findBy(['enabled' => true]);
    }
}
