<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Matcher\Matcher;
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

        $matcher = new Matcher();
        $matcher->addVoter(new SmartUriVoter($this->container));

        $renderer = new ListRenderer($matcher);
        $renderer->render($menu);

        return $menu;
    }
}
