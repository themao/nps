<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'isHomepage' => $request->getPathInfo() == '/',
            ]
        );
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
