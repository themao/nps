<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request, TranslatorInterface $translator, PageRepository $pageRepo, Environment $twig, string $path = ''): Response
    {
        $pathInfo = $request->getPathInfo();
        if (!in_array(substr($pathInfo, 1, 2), ['en', 'ru', 'ua'])) {
            $redirect = rtrim('/' . $request->getLocale() . $pathInfo, '/');
            return $this->redirect($redirect, 301);
        }

        $title = $translator->trans('home.title');
        if (!$path) {
            return $this->render('Default/index.html.twig', [
                'isHomepage' => true,
                'title' => $title,
                'meta' => $translator->trans('home.meta'),
            ]);
        }

        $page = $pageRepo->findOneBy(['slug' => $path]);

        if (!$page) {
            throw $this->createNotFoundException('No such page!');
        }

        // render as twig template
        $template = $twig->createTemplate($page->getContent());
        $page->getCurrentTranslation()->setContent($template->render([]));
        $contactProductData = [
            'title' => $page->getCurrentTranslation()->getTitle(),
        ];

        return $this->render('Page/index.html.twig', [
            'contactProductData' => $contactProductData,
            'inquiryFormProductData' => ['title' => 'Contact Page'],
            'page' => $page,
            'title' => "{$page->getCurrentTranslation()->getTitle()} | $title",
            'meta' => $page->getCurrentTranslation()->getMetaDescription(),
        ]);
    }

    public function localeAction(Request $request, string $_locale): Response
    {
        $request->getSession()->set('_locale', $_locale);

        return $this->forward(self::class.'::indexAction');
    }

    public function privacyPolicyAction(): Response
    {
        return $this->render('Default/privacy_policy.en.html.twig');
    }
}
