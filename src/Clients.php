<?php

namespace IlBronza\Clients;

class Clients
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
            'href' => route('clients.index')
        ]);

        $destinationsButton = $menu->createButton([
            'name' => 'destinations.index',
            'icon' => 'users',
            'text' => 'clients::destinations.list',
            'href' => route('destinations.index')
        ]);

        $referentsButton = $menu->createButton([
            'name' => 'referents.index',
            'icon' => 'users',
            'text' => 'clients::referents.list',
            'href' => route('referents.index')
        ]);

        $button->addChild($clientsManagerButton);

        $clientsManagerButton->addChild($clientsButton);
        $clientsManagerButton->addChild($destinationsButton);
        $clientsManagerButton->addChild($referentsButton);

    }
}