<?php

namespace IlBronza\Clients\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDBelongsToManyTrait;
use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDDestroyTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\CRUD\Traits\CRUDUpdateEditorTrait;
use IlBronza\Clients\Http\ParametersFile\CrudDestinationtypeParameters;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Ukn\Ukn;
use Illuminate\Http\Request;

class CrudDestinationtypeController extends CRUD
{
    use CRUDShowTrait;
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDEditUpdateTrait;
    use CRUDUpdateEditorTrait;
    use CRUDCreateStoreTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    use CRUDRelationshipTrait;
    use CRUDBelongsToManyTrait;

    public $parametersFile = CrudDestinationtypeParameters::class;

    public function setModelClass()
    {
        $this->modelClass = config('clients.models.destinationtype.class');
    }

    public static $tables = [

        'index' => [
            'translationPrefix' => 'clients::fields',
            'fields' => 
            [
                'name' => 'flat',
                'slug' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ],
        'related' => [
            'translationPrefix' => 'clients::fields',
            'fields' => 
            [
                'name' => 'flat',
                'slug' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    // static $formFields = [
    //     'common' => [
    //         'default' => [
    //             'client_id' => [
    //                 'type' => 'select',
    //                 'multiple' => false,
    //                 'rules' => 'string|nullable|exists:clients,id',
    //                 'relation' => 'client',
    //                 'disabled' => true
    //             ],
    //             'name' => ['text' => 'string|required|max:191'],
    //             'slug' => ['text' => 'string|nullable|max:191'],
    //             'type' => ['text' => 'string|nullable|max:191']
    //         ]
    //     ]
    // ];    

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('clients.routePrefix');
    }

    /**
     * subject model class full path
     **/
    public $modelClass = Destinationtype::class;
    public $returnBack = true;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'show',
        'edit',
        'update',
        'create',
        'store',
        'destroy',
    ];

    public function getIndexElements()
    {
        return $this->getModelClass()::all();
    }

    public function getDestinationtype(int|string $destinationtype)
    {
        return $this->getModelClass()::find($destinationtype);
    }

    public function show(int|string $destinationtype)
    {
        $destinationtype = $this->getDestinationtype($destinationtype);

        return $this->_show($destinationtype);
    }

    public function edit(int|string $destinationtype)
    {
        $destinationtype = $this->getDestinationtype($destinationtype);

        return $this->_edit($destinationtype);
    }

    public function update(Request $request, int|string $destinationtype)
    {
        $destinationtype = $this->getDestinationtype($destinationtype);

        return $this->_update($request, $destinationtype);
    }

    public function destroy(int|string $destinationtype)
    {
        $destinationtype = $this->getDestinationtype($destinationtype);

        return $this->_destroy($destinationtype);
    }
}

