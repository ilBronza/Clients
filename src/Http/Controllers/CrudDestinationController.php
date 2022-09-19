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

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destination;

use Illuminate\Http\Request;

class CrudDestinationController extends CRUD
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

    public static $tables = [

        'index' => [
            'fields' => 
            [
                'client' => [
                    'type' => 'links.see',
                    'textParameter' => 'name'
                ],
                'name' => 'flat',
                'slug' => 'flat',
                'type' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ],
        'related' => [
            'fields' => 
            [
                'name' => 'flat',
                'slug' => 'flat',
                'type' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    static $formFields = [
        'common' => [
            'default' => [
                'client_id' => [
                    'type' => 'select',
                    'multiple' => false,
                    'rules' => 'string|nullable|exists:clients,id',
                    'relation' => 'client'
                ],
                'name' => ['text' => 'string|required|max:191'],
                'slug' => ['text' => 'string|nullable|max:191'],
                'type' => ['text' => 'string|nullable|max:191']
            ]
        ]
    ];    

    /**
     * subject model class full path
     **/
    public $modelClass = Destination::class;
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
        'createFromClient',
        'store',
        'destroy',
        'deleted',
    ];


    public function getIndexElements()
    {
        return Destination::all();
    }

    public function show(Destination $destination)
    {
        return $this->_show($destination);
    }

    public function createFromClient(Client $client)
    {
        $destination = Destination::make();
        $destination->client_id = $client->getKey();
        $destination->name = $client->getName();
        $destination->save();

        return $this->edit($destination);
    }

    public function edit(Destination $destination)
    {
        return $this->_edit($destination);
    }

    public function update(Request $request, Destination $destination)
    {
        return $this->_update($request, $destination);
    }

    public function destroy(Destination $destination)
    {
        return $this->_destroy($destination);
    }
}

