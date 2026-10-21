<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

#[AsEventListener]
class ExceptionListener
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            $request = $event->getRequest();
            $failedUrl = $request->getPathInfo();

            preg_match('#^/production|products/(.+?)/?$#is', $failedUrl, $matches);
            if (isset($matches[1])) {
                $url = $this->router->generate('products', [
                    '_locale' => $request->getLocale(),
                    'slug' => $matches[1],
                ]);
            } else if (str_contains($failedUrl, '//')) {
                $url = str_replace('//', '/', $failedUrl);
            } else if (str_ends_with($failedUrl, '/')) {
                $url = preg_replace('#/$#', '', $failedUrl);
            }

            if (isset($url) && $url !== $failedUrl) {
                $event->setResponse(new RedirectResponse($url, 301));
            }
        }
    }
}
