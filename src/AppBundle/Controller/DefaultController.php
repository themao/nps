<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $path = '')
    {
        if (!$path) {
            return $this->render('AppBundle:Default:index.html.twig', ['isHomepage' => true]);
        }

        $pageRepo = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page');
        $page = $pageRepo->findOneBy(['slug' => $path]);

        if (!$page) {
            return $this->createNotFoundException('No such page!');
        }

        return $this->render('AppBundle:Page:index.html.twig', ['page' => $page]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function translationAction(Request $request)
    {
        $productionRepo = $this->get('doctrine')->getRepository('AppBundle:Production');
        $productionList = $productionRepo->findAll();

        return $this->render(
            'AppBundle:Default:translation.html.twig',
            [
                'productionList' => $productionList
            ]
        );
    }
}
