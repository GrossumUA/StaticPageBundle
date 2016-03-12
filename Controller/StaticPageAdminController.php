<?php

namespace Grossum\StaticPageBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Grossum\StaticPageBundle\Entity\EntityManager\StaticPageManager;

class StaticPageAdminController extends Controller
{
    const TREE_ACTION = 'tree';
    /**
     * @return Response
     */
    public function treeAction()
    {
        $root = $this->get('grossum_static_page.static_page.manager')->getRepository()->findRootStaticPage();
        $formView = $this->admin->getDatagrid()->getForm()->createView();
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render(
            'GrossumStaticPageBundle:StaticPageAdmin:tree.html.twig',
            [
                'action' => self::TREE_ACTION,
                'root_static_page' => $root,
                'form' => $formView,
                'csrf_token' => $this->getCsrfToken('sonata.batch'),
                'grossum_static_page_tree_depth' => $this->getParameter('grossum_static_page_tree_depth'),
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveTreeAction(Request $request)
    {
        $tree = $request->request->get('tree');

        /**
         * @var StaticPageManager $staticPageManager
         */
        $staticPageManager = $this->get('grossum_static_page.static_page.manager');
        $verified = $staticPageManager->updateAndVerifyTree($tree);

        if ($verified !== true) {
            return new JsonResponse(['result' => false]);
        }

        $staticPageManager->flush();

        return new JsonResponse(['result' => true]);
    }
}
