<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Matcher\Voter\UriVoter;
use Knp\Menu\Renderer\ListRenderer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('menu.main_page', [
            'route' => 'app_default',
        ]);
        $menu->addChild('menu.about', [
            'route' => 'app_default',
            'routeParameters' => ['path' => 'about'],
        ]);
        $menu->addChild('menu.services', [
            'route' => 'app_default',
            'routeParameters' => ['path' => 'services'],
        ]);
        $menu->addChild('menu.products', [
            'route' => 'app_default',
            'routeParameters' => ['path' => 'products'],
        ]);
        $menu->addChild('menu.contact', [
            'route' => 'app_default',
            'routeParameters' => ['path' => 'contact'],
        ]);

        $menu['menu.main_page']->setCurrent(false);

        $matcher = new Matcher();
        $matcher->addVoter(new UriVoter($_SERVER['REQUEST_URI']));

        $renderer = new ListRenderer($matcher);
        $renderer->render($menu);

        return $menu;
    }
}