<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $path)
    {
        $pageRepo = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page');
        $page = $pageRepo->findOneBy(['slug' => $path]);

        if (!$page) {
            return $this->createNotFoundException('No such page!');
        }

        return $this->render(
            'AppBundle:Page:index.html.twig', [
                'page' => $page,
                'isHomepage' => false,
            ]
        );
    }
}
