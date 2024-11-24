<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class DestinationEditUpdateController extends DestinationCRUD
{
    use CRUDEditUpdateTrait;
	public $returnBack = true;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        //DestinationCreateStoreFieldsetsParameters
        return config('clients.models.destination.parametersFiles.create');
    }

    public function edit(string $destination)
    {
        $destination = $this->findModel($destination);

        return $this->_edit($destination);
    }

    public function update(Request $request, $destination)
    {
        $destination = $this->findModel($destination);

        return $this->_update($request, $destination);
    }
}
