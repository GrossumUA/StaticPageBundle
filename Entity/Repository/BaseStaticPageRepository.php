<?php

namespace Grossum\StaticPageBundle\Entity\Repository;

use Doctrine\ORM\NonUniqueResultException;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Gedmo\Tree\Strategy\ORM\Nested;

use Grossum\StaticPageBundle\Entity\BaseStaticPage;

abstract class BaseStaticPageRepository extends NestedTreeRepository
{
    /**
     * @return BaseStaticPage[]
     */
    public function findAllEnabled()
    {
        return $this->findBy(['enabled' => true]);
    }

    /**
     * @return BaseStaticPage
     * @throws NonUniqueResultException
     */
    public function findRootStaticPage()
    {
        $qb = $this->createQueryBuilder('static_page');
        $qb
            ->where(
                $qb->expr()->isNull('static_page.parent')
            )
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param array $children
     * @return array
     */
    public function findAllExcept(array $children)
    {
        $qb = $this->createQueryBuilder('static_page');
        $qb->where($qb->expr()->notIn('static_page.title', $children));

        return $qb->getQuery()->getResult();
    }
}
