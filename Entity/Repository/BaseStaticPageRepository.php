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
     * Set as first child of a new parent - Tree hierarchy, it doesn't touch ORM relation.
     *
     * In ORM:
     *     $node->setParent($newParent);
     * It updates ORM relation only, doesn't touch Tree hierarchy.
     *
     * @param BaseStaticPage $staticPage
     * @param BaseStaticPage $newParent
     *
     * @return void
     */
    public function setNewParent($staticPage, $newParent)
    {
        $meta     = $this->getClassMetadata();
        $strategy = $this->listener->getStrategy($this->_em, $meta->name);
        /* @var $strategy Nested */

        $strategy->updateNode($this->_em, $staticPage, $newParent);
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
     * @return int
     */
    public function getMaxPosition()
    {
        $qb = $this->createQueryBuilder('static_page');
        $qb->select('max(static_page.position)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
