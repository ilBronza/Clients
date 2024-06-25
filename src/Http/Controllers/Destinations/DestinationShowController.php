<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Http\Controllers\BasePackageShowTrait;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationCRUD;

class DestinationShowController extends DestinationCRUD
{
    use BasePackageShowTrait;

    public function show(string $destination)
    {
        $destination = $this->findModel($destination);

        return $this->_show($destination);
    }
}
