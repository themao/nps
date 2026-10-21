<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Enables the oneLocale filter for the request locale, except on Sonata create/edit where all translations are needed.
 * Ported from A2lix I18nDoctrineBundle's ControllerListener.
 */
#[AsEventListener]
class OneLocaleFilterListener
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function __invoke(ControllerEvent $event): void
    {
        $controller = $event->getController();
        $filters = $this->em->getFilters();

        if (\is_array($controller) && $controller[0] instanceof CRUDController && \in_array($controller[1], ['createAction', 'editAction'], true)) {
            if ($filters->isEnabled('oneLocale')) {
                $filters->disable('oneLocale');
            }

            return;
        }

        $filters->enable('oneLocale')->setParameter('locale', $event->getRequest()->getLocale());
    }
}
