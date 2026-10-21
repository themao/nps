<?php

namespace App\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Voter based on the uri
 */
#[AutoconfigureTag('knp_menu.voter')]
class SmartUriVoter implements VoterInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function matchItem(ItemInterface $item): ?bool
    {
        $currentUri = $this->requestStack->getMainRequest()?->server->get('REQUEST_URI');

        if (null === $currentUri || null === $item->getUri()) {
            return null;
        }

        $uri = parse_url($currentUri);
        $itemUri = parse_url($item->getUri());
        $moduleMatches = false;

        if (isset($uri['path'], $itemUri['path'])) {
            $uriParts = explode('/', $uri['path']);
            $itemParts = explode('/', $itemUri['path']);

            if (isset($uriParts[2], $itemParts[2])) {
                $moduleMatches = $uriParts[2] == $itemParts[2];
            }
        }

        if ($item->getUri() === $currentUri || $moduleMatches) {
            return true;
        }

        return null;
    }
}
