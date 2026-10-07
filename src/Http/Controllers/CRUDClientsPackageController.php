<?php

namespace IlBronza\Clients\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Http\Controllers\BasePackageTrait;
use Illuminate\Database\Eloquent\Model;

class CRUDClientsPackageController extends CRUD
{
    use BasePackageTrait;

    static $packageConfigPrefix = 'clients';

    public function findModel(string $key, array $relations = []) : ?Model
    {
        $model = $this->getFindModelQuery($key, $relations)->findOrFail($key);
        $this->setModel($model);

        return $model;
    }

}
