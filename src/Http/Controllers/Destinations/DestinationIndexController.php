<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationCRUD;

class DestinationIndexController extends DestinationCRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexFieldsArray()
    {
        return config('clients.models.destination.fieldsGroupsFiles.index')::getFieldsGroup();
    }

    public function getRelatedFieldsArray()
    {
        return config('clients.models.destination.fieldsGroupsFiles.related')::getFieldsGroup();
    }

    public function getIndexElements()
    {
        ini_set('max_execution_time', "180");
        ini_set('memory_limit', "-1");

        return $this->getModelClass()::with(
            'address',
            'client',
            'types'
        )->get();
    }

}
