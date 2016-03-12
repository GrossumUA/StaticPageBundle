<?php

namespace Grossum\StaticPageBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Grossum\StaticPageBundle\Entity\BaseStaticPage;

class LoadRootStaticPageData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityClass = $this->container->getParameter('grossum_static_page.entity.static_page.class');

        /* @var $staticPage BaseStaticPage */
        $staticPage = new $entityClass();

        $staticPage->setTitle(BaseStaticPage::ROOT);
        $staticPage->setBody(BaseStaticPage::ROOT);

        $manager->persist($staticPage);
        $manager->flush();
    }
}
