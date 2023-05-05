<?php

namespace IlBronza\Clients;

use IlBronza\CRUD\Providers\RouterProvider\IbRouter;
use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;

class Clients implements RoutedObjectInterface
{
    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $button = $menu->provideButton([
                'text' => 'generals.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $clientsManagerButton = $menu->createButton([
            'name' => 'clientsManager',
            'icon' => 'user-gear',
            'text' => 'clients::clients.list'
        ]);

        $clientsButton = $menu->createButton([
            'name' => 'clients.index',
            'icon' => 'users',
            'text' => 'clients::clients.list',
            'href' => IbRouter::route($this, 'clients.index')
        ]);

        $destinationsButton = $menu->createButton([
            'name' => 'destinations.index',
            'icon' => 'users',
            'text' => 'clients::destinations.list',
            'href' => IbRouter::route($this, 'destinations.index')
        ]);

        $referentsButton = $menu->createButton([
            'name' => 'referents.index',
            'icon' => 'users',
            'text' => 'clients::referents.list',
            'href' => IbRouter::route($this, 'referents.index')
        ]);

        $button->addChild($clientsManagerButton);

        $clientsManagerButton->addChild($clientsButton);
        $clientsManagerButton->addChild($destinationsButton);
        $clientsManagerButton->addChild($referentsButton);

    }

    public function getController(string $target)
    {
        return config("clients.models.{$target}.controller");
    }

    public function getRoutePrefix() : ? string
    {
        return config('clients.routePrefix');
    }
}