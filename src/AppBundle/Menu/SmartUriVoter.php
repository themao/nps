<?php

namespace AppBundle\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Voter based on the uri
 */
class SmartUriVoter implements VoterInterface
{
    private $uri;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->uri = $this->container->get('request')->server->get('REQUEST_URI');
    }

    public function matchItem(ItemInterface $item)
    {
        if (null === $this->uri || null === $item->getUri()) {
            return null;
        }

        $uri = parse_url(str_replace('/app_dev.php/', '', $this->uri));
        $itemUri = parse_url(str_replace('/app_dev.php/', '', $item->getUri()));
        $moduleMatches = false;
        if (isset($uri['path'], $itemUri['path'])) {
            $uriParts = explode('/', $uri['path']);
            $itemParts = explode('/', $itemUri['path']);
            $moduleMatches = $uriParts[1] == $itemParts[1];
        }
        if ($item->getUri() === $this->uri || $moduleMatches) {
            return true;
        }

        return null;
    }
}
