<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $slug)
    {
        $productRepo = $this->container->get('doctrine')->getRepository('AppBundle:Product');
        if ($product = $productRepo->findOneBy(['slug' => $slug])) {
            return $this->render(
                'AppBundle:Product:index.html.twig',
                [
                    'product' => $product,
                ]
            );
        }
        $this->createNotFoundException();
    }
}
