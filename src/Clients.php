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

        $destinationTypesButton = $menu->createButton([
            'name' => 'destinationtypes.index',
            'icon' => 'users',
            'text' => 'clients::destinationtypes.list',
            'href' => IbRouter::route($this, 'destinationtypes.index')
        ]);

        $operatorsButton = $menu->createButton([
            'name' => 'operators.index',
            'icon' => 'users',
            'text' => 'clients::operators.list',
            'href' => IbRouter::route($this, 'operators.index')
        ]);

        $button->addChild($clientsManagerButton);

        $clientsManagerButton->addChild($clientsButton);
        $clientsManagerButton->addChild($destinationsButton);
        $clientsManagerButton->addChild($destinationTypesButton);
        $clientsManagerButton->addChild($referentsButton);
        $clientsManagerButton->addChild($operatorsButton);

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

    public function getController(string $target, string $type = null) : string
    {
        if($type)
            try
            {
                return config("clients.models.{$target}.controllers.{$type}");
            }
            catch(\Throwable $e)
            {
                dd([$e->getMessage(), 'dichiara ' . "clients.models.{$target}.controllers.{$type}"]);
            }

        try
        {
            return config("clients.models.{$target}.controller");
        }
        catch(\Throwable $e)
        {
            dd([$e->getMessage(), 'dichiara ' . "clients.models.{$target}.controller"]);
        }
    }

    public function getRoutePrefix() : ? string
    {
        return config('clients.routePrefix');
    }
}