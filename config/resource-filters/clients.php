<?php

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\ResourceFilters\ClientFilters;
use IlBronza\Clients\ResourceFilters\ClientFilterScope;

return [
    'model' => Client::class,
    'helper' => ClientFilters::class,
    'scope' => ClientFilterScope::class,
    'label' => 'clients::resource-filters.clients',
    'enabled' => false,
];
