<?php

namespace IlBronza\Clients;

use IlBronza\CRUD\Providers\RouterProvider\IbRouter;
use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;

class Clients implements RoutedObjectInterface
{
    use IlBronzaPackagesTrait;
    static string $packageConfigPrefix = 'clients';


    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $button = $menu->provideButton([
                'text' => 'menu::menu.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $clientsManagerButton = $menu->createButton([
            'name' => 'clientsManager',
            'icon' => 'building',
            'text' => 'clients::clients.list'
        ]);

        $clientsButton = $menu->createButton([
            'name' => 'clients.index',
            'icon' => 'list',
            'text' => 'clients::clients.list',
            'href' => IbRouter::route($this, 'clients.index'),
            'children' => [
                [
                    'name' => 'clients.clients',
                    'icon' => 'building',
                    'text' => 'clients::clients.clients',
                    'href' => IbRouter::route($this, 'clients.clients.index'),
                ],
                [
                    'name' => 'clients.suppliers',
                    'icon' => 'industry',
                    'text' => 'clients::clients.suppliers',
                    'href' => IbRouter::route($this, 'clients.suppliers.index'),
                ]
            ]
        ]);

        $destinationsButton = $menu->createButton([
            'name' => 'destinations.index',
            'icon' => 'globe',
            'text' => 'clients::destinations.list',
            'href' => IbRouter::route($this, 'destinations.index')
        ]);

        $referentsButton = $menu->createButton([
            'name' => 'referents.index',
            'icon' => 'user-doctor',
            'text' => 'clients::referents.list',
            'href' => IbRouter::route($this, 'referents.index')
        ]);

        $button->addChild($clientsManagerButton);

        $clientsManagerButton->addChild($clientsButton);
        $clientsManagerButton->addChild($destinationsButton);
        $clientsManagerButton->addChild($referentsButton);

    }

    public function hasClientPrivateArea() : bool
    {
        return !! config("clients.privateArea.client.enabled", false);
    }

    public function hasDestinations() : bool
    {
        return !! config("clients.destinations.enabled", false);
    }

    public function hasReferents() : bool
    {
        return !! config("clients.referents.enabled", false);
    }
}