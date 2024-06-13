<?php

namespace IlBronza\Clients\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Http\Controllers\BasePackageTrait;

class CRUDClientsPackageController extends CRUD
{
    use BasePackageTrait;

    static $packageConfigPrefix = 'clients';

}
