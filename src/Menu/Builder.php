<?php

namespace App\Menu;

use Knp\Menu\Attribute\AsMenuBuilder;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class Builder
{
    public function __construct(private FactoryInterface $factory)
    {
    }

    #[AsMenuBuilder(name: 'top')]
    public function topMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('menu.main_page', [
            'route' => 'app',
        ]);
        $menu->addChild('menu.about', [
            'route' => 'app',
            'routeParameters' => ['path' => 'about'],
        ]);
        $menu->addChild('menu.services', [
            'route' => 'app',
            'routeParameters' => ['path' => 'services'],
        ]);
        $menu->addChild('menu.products', [
            'route' => 'app',
            'routeParameters' => ['path' => 'products'],
        ]);
        $menu->addChild('menu.contact', [
            'route' => 'app',
            'routeParameters' => ['path' => 'contact'],
        ])->setLabel('menu.contact');
        $menu->addChild('menu.close')->setLabel('+')->setAttribute('class', 'close');

        $menu['menu.main_page']->setCurrent(false);

        return $menu;
    }
}
