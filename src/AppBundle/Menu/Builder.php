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

        $menu->addChild('top_menu.main_page', ['route' => 'app_index']);
        $menu->addChild('top_menu.about', ['route' => 'app_index']);
        $menu->addChild('top_menu.services', ['route' => 'app_index']);
        $menu->addChild('top_menu.products', ['route' => 'app_index']);
        $menu->addChild('top_menu.contact', ['route' => 'app_index']);

        return $menu;
    }
}
