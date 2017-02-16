<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('menu.main_page', [
            'route' => 'app_page',
        ]);
        $menu->addChild('menu.about', [
            'route' => 'app_page',
            'routeParameters' => ['path' => 'about'],
        ]);
        $menu->addChild('menu.services', [
            'route' => 'app_page',
            'routeParameters' => ['path' => 'services'],
        ]);
        $menu->addChild('menu.products', [
            'route' => 'app_page',
            'routeParameters' => ['path' => 'products'],
        ]);
        $menu->addChild('menu.contact', [
            'route' => 'app_page',
            'routeParameters' => ['path' => 'contact'],
        ]);

        return $menu;
    }
}
