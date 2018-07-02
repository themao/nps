<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\UrlRedirect;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener
{
    /** @var  EntityManagerInterface */
    private $em;

    use ContainerAwareTrait;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->em = $entityManager;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof NotFoundHttpException) {
            $request = $event->getRequest();
            $failedUrl = $request->getPathInfo();
            /** @var RouterInterface $router */
            $router = $this->container->get('router');

            preg_match('#^/production|products/(.+?)/?$#is', $failedUrl, $matches);
            if (isset($matches[1])) {
                $url = $router->generate('products', [
                    '_locale' => $request->getLocale(),
                    'slug' => $matches[1],
                ]);
                $event->setResponse(new RedirectResponse($url, 301));
            } else if (strpos($failedUrl, '//') !== false) {
                $url = str_replace('//', '/', $failedUrl);
                $event->setResponse(new RedirectResponse($url, 302));
            }

            $urlRedirect = new UrlRedirect();
            $urlRedirect
                ->setOldUrl($failedUrl)
                ->setNewUrl(isset($url) ? $url : null)
                ->setReferer($request->headers->get('referer'))
            ;
            $this->em->persist($urlRedirect);
            $this->em->flush();
        }
    }
}
