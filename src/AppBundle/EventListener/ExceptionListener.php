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
            } else if (strpos($failedUrl, '//') !== false) {
                $url = str_replace('//', '/', $failedUrl);
            } else if (substr($failedUrl, -1, 1) === '/') {
                $url = preg_replace('#/$#', '', $failedUrl);
            }

            if (isset($url)) {
                $event->setResponse(new RedirectResponse($url, 301));
            }
        }
    }
}
