<?php
namespace Ghyneck\MapBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    /*
     * @param FactoryInterface $factory
     * array $options
     *
     * @return Knp\Menu
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $layout = $menu->addChild('regions', array(
            'route' => 'category',
        ));

        return $menu;
    }
}