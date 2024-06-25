<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class DestinationDestroyController extends DestinationCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($destination)
    {
        $destination = $this->findModel($destination);

        return $this->_destroy($destination);
    }
}