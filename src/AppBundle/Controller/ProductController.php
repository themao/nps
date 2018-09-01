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
            $translation = $product->getCurrentTranslation();
            if ($translation->getContent()) {
                $template = $this->get('twig')->createTemplate($translation->getContent());
                $content = $template->render([]);
            } else {
                $content = '';
            }
            $translator = $this->get('translator');
            $title = $translator->trans('home.title');
            $productsTitle = $translator->trans('home.products_title');
            return $this->render(
                'AppBundle:Product:index.html.twig',
                [
                    'product' => $product,
                    'content' => $content,
                    'title' => "$title - $productsTitle - {$product->getTitle()}",
                    'meta' => $product->getMetaDescription(),
                ]
            );
        }
        throw $this->createNotFoundException();
    }
}
