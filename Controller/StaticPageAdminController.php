<?php

namespace Grossum\StaticPageBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;

use Application\Grossum\StaticPageBundle\Entity\StaticPage;

class StaticPageAdminController extends Controller
{
    /**
     * @return Response
     */
    public function treeAction()
    {
        $rootStaticPages = $this
            ->get('grossum_static_page.static_page.manager')
            ->getRepository()
            ->childrenHierarchy();

        if (count($rootStaticPages) > 1) {
            throw new \RuntimeException('Wrong number of roots elements. It must be one.');
        }

        $rootStaticPage = $rootStaticPages[0];
        $formView       = $this->admin->getDatagrid()->getForm()->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render('GrossumStaticPageBundle:StaticPageAdmin:tree.html.twig', array(
            'action'                         => 'tree',
            'root_static_page'               => $rootStaticPage,
            'form'                           => $formView,
            'csrf_token'                     => $this->getCsrfToken('sonata.batch'),
            'grossum_static_page_tree_depth' => $this->getParameter('grossum_static_page_tree_depth')
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function saveTreeAction(Request $request)
    {
        $newTree = $request->request->get('tree');

        $staticPageRepo = $this
            ->get('grossum_static_page.static_page.manager')
            ->getRepository();

        // caching all pages from database
        $staticPageRepo->findAll();

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($newTree),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $rootStaticPage = $staticPageRepo->findRootStaticPage();
        $lastStaticPage = $rootStaticPage;
        $parents        = [
            0 => $rootStaticPage
        ];
        $position       = 1;
        $depth          = 1;
        $lastDepth      = $depth;

        foreach ($iterator as $staticPageId) {
            $depth = round(($iterator->getDepth() - 1)/2);

            if ($depth > $lastDepth) {
                $parents[$depth] = $lastStaticPage;
            }

            $staticPage = $staticPageRepo->find($staticPageId);

            $staticPage->setParent($parents[$depth]);
            $staticPage->setPosition($position);

            $lastStaticPage = $staticPage;
            $lastDepth      = $depth;

            ++$position;
        }

        $connection = $this->getDoctrine()->getConnection();
        /* @var $connection Connection */

        // GedmoTree-extension make changes in database without transactions, but we want to have not broken tree,
        // that's why we manage transaction manually
        try {
            $connection->beginTransaction();

            $this->getDoctrine()->getManager()->flush();
            $staticPageRepo->reorder($rootStaticPage, 'position');
            $this->getDoctrine()->getManager()->flush();

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();

            throw $e;
        }

        return new JsonResponse(['result' => true]);
    }
}
