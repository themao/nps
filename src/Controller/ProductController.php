<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class ProductController extends AbstractController
{
    public function indexAction(ProductRepository $productRepo, TranslatorInterface $translator, Environment $twig, string $slug = ''): Response
    {
        if ($product = $productRepo->findOneBy(['slug' => $slug])) {
            $translation = $product->getCurrentTranslation();
            if ($translation->getContent()) {
                $template = $twig->createTemplate($translation->getContent());
                $content = $template->render([]);
            } else {
                $content = '';
            }
            $title = $translator->trans('home.title');
            $productsTitle = $translator->trans('home.products_title');
            return $this->render(
                'Product/index.html.twig',
                [
                    'product' => $product,
                    'content' => $content,
                    'title' => "$productsTitle - {$product->getTitle()} | $title",
                    'meta' => $product->getMetaDescription(),
                ]
            );
        }
        throw $this->createNotFoundException();
    }
}
