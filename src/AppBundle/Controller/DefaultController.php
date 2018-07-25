<?php

namespace AppBundle\Controller;

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
        $pathInfo = $request->getPathInfo();
        if (!in_array(substr($pathInfo, 1, 2), ['en', 'ru', 'ua'])) {
            $redirect = rtrim('/' . $request->getLocale() . $pathInfo, '/');
            return $this->redirect($redirect, 301);
        }

        $translator = $this->get('translator');
        $title = $translator->trans('home.title');
        if (!$path) {
            return $this->render('AppBundle:Default:index.html.twig', [
                'isHomepage' => true,
                'title' => $title,
                'meta' => $translator->trans('home.meta'),
            ]);
        }

        $pageRepo = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page');
        $page = $pageRepo->findOneBy(['slug' => $path]);

        if (!$page) {
            throw $this->createNotFoundException('No such page!');
        }

        // render as twig template
        $template = $this->get('twig')->createTemplate($page->getContent());
        $page->getCurrentTranslation()->setContent($template->render([]));
        $contactProductData = [
            'title' => $page->getCurrentTranslation()->getTitle(),
        ];

        return $this->render('AppBundle:Page:index.html.twig', [
            'contactProductData' => $contactProductData,
            'page' => $page,
            'title' => "$title - {$page->getCurrentTranslation()->getTitle()}",
            'meta' => $page->getCurrentTranslation()->getMetaDescription(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function localeAction(Request $request, $locale)
    {
        $request->getSession()->set('_locale', $locale);
        $this->forward('AppBundle:Default:index');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function privacyPolicyAction(Request $request)
    {
        return $this->render('AppBundle:Default:privacy_policy.en.html.twig');
    }
}
