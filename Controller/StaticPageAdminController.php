<?php

namespace Grossum\StaticPageBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Grossum\StaticPageBundle\Entity\EntityManager\StaticPageManager;

use Application\Grossum\StaticPageBundle\Entity\StaticPage;

class StaticPageAdminController extends Controller
{
    /**
     * @return Response
     */
    public function treeAction()
    {
        $root = $this->get('grossum_static_page.static_page.manager')->getRepository()->findRootStaticPage();
        $formView       = $this->admin->getDatagrid()->getForm()->createView();
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render('GrossumStaticPageBundle:StaticPageAdmin:tree.html.twig', array(
            'action'                         => 'tree',
            'root_static_page'               => $root,
            'form'                           => $formView,
            'csrf_token'                     => $this->getCsrfToken('sonata.batch'),
            'grossum_static_page_tree_depth' => $this->getParameter('grossum_static_page_tree_depth')
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveTreeAction(Request $request)
    {
        $newTree = $request->request->get('tree');

        /**
         * @var StaticPageManager $staticPageManager
         */
        $staticPageManager = $this->get('grossum_static_page.static_page.manager');

        $root = $staticPageManager->getRepository()->findRootStaticPage();

        foreach ($newTree as $treeData) {
            if (isset($treeData['item_id']) && $treeData['item_id'] === StaticPage::ROOT) {
                continue;
            }

            if (!isset($treeData['parent_id']) || !isset($treeData['id'])) {
                continue;
            }

            /**
             * @var StaticPage $staticPage
             */
            $staticPage = $staticPageManager->getRepository()->find($treeData['id']);
            $parentId = ($treeData['parent_id'] === StaticPage::ROOT) ? $root->getId() : $treeData['parent_id'];
            $parentStaticPage = $staticPageManager->getRepository()->find($parentId);

            $staticPage->setParent($parentStaticPage)
                ->setLft($treeData['left'])
                ->setRgt($treeData['right']);
        }

        $verified = $staticPageManager->getRepository()->verify();

        if ($verified !== true) {
            return new JsonResponse(['result' => false]);
        }
        $staticPageManager->flush();

        return new JsonResponse(['result' => true]);
    }
}
