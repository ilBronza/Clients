<?php

namespace IlBronza\Clients\Http\Controllers\Client;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class ClientShowController extends ClientCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function show(string $type)
    {
        $type = $this->findModel($type);

        return $this->_show($type);
    }
}
