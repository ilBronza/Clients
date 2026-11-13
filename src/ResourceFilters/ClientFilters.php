<?php

namespace IlBronza\Clients\ResourceFilters;

use IlBronza\CRUD\ResourceFilters\ResourceFilterHelper;

class ClientFilters extends ResourceFilterHelper
{
    public function getFilters(): array
    {
        return [
            'ids' => $this->identifiers('clients::resource-filters.clients'),
        ];
    }
}
