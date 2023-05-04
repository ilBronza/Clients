<?php

namespace IlBronza\Clients\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDBelongsToManyTrait;
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
use IlBronza\Ukn\Facades\Ukn;
use Illuminate\Http\Request;

class CrudDestinationController extends CRUD
{
    use CRUDShowTrait;
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDEditUpdateTrait;
    use CRUDUpdateEditorTrait;
    // use CRUDCreateStoreTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    use CRUDRelationshipTrait;
    use CRUDBelongsToManyTrait;

    public function setModelClass()
    {
        $this->modelClass = config('clients.models.destination.class');
    }

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
        // 'create',
        'createFromClient',
        // 'store',
        'destroy',
        'deleted',
    ];

    public function getAfterUpdatedRedirectUrl()
    {
        return $this->getModel()->getClient()->getShowUrl();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('client', 'referents')->get();
    }

    public function getDestination(int|string $destination)
    {
        return $this->getModelClass()::find($destination);
    }

    public function show(int|string $destination)
    {
        $destination = $this->getDestination($destination);

        return $this->_show($destination);
    }

    public function getClient($client)
    {
        return Client::getProjectClassName()::find($client);
    }

    public function createFromClient(int|string $client)
    {
        $client = $this->getClient($client);

        $destination = $this->getModelClass()::make();
        $destination->client_id = $client->getKey();
        $destination->name = $client->getName();
        $destination->save();

        Ukn::s(__('clients::destinations.createdForClient', ['client' => $client->getName()]));

        return $this->_edit($destination);
    }

    public function edit(int|string $destination)
    {
        $destination = $this->getDestination($destination);

        return $this->_edit($destination);
    }

    public function update(Request $request, int|string $destination)
    {
        $destination = $this->getDestination($destination);

        return $this->_update($request, $destination);
    }

    public function destroy(int|string $destination)
    {
        $destination = $this->getDestination($destination);

        return $this->_destroy($destination);
    }
}

