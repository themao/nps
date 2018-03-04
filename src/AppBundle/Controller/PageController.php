<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $path = '')
    {
        if (!$path) {
            return $this->forward('AppBundle:Default:index');
        }

        $pageRepo = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page');
        /** @var Page $page */
        $page = $pageRepo->findOneBy(['slug' => $path]);

        if (!$page) {
            return $this->createNotFoundException('No such page!');
        }

        // render as twig template
        $template = $this->get('twig')->createTemplate($page);
        $page = $template->render([]);
        $contactProductData = [
            'title' => $page->getCurrentTranslation()->getTitle(),
        ];

        return $this->render(
            'AppBundle:Page:index.html.twig', [
                'contactProductData' => $contactProductData,
                'page' => $page,
                'meta' => $page->getCurrentTranslation()->getMetaDescription(),
                'isHomepage' => false,
            ]
        );
    }
}
