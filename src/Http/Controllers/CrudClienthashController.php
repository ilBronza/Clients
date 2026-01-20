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
use IlBronza\Clients\Http\ParametersFile\Hash\HashParameters;
use IlBronza\Clients\Models\Client;
use IlBronza\Ukn\Ukn;
use Illuminate\Http\Request;

class CrudClienthashController extends CRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    use CRUDEditUpdateTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    use CRUDRelationshipTrait;
    use CRUDBelongsToManyTrait;

    public static $tables = [

        'related' => [
            'translationPrefix' => 'clients::fields',
            'fields' => 
            [
                'created_at' => 'dates.datetime',

                'id' => 'flat',
                'used_at' => 'dates.datetime',
                'permanent' => 'boolean',
                'valid_to' => 'dates.datetime',

                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    // public $returnBack = true;

    public function setModelClass()
    {
        $this->modelClass = config('clients.models.clienthash.class');
    }

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('clients.routePrefix');
    }

    public $parametersFile = HashParameters::class;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'edit',
        'update',
        'destroy',
        'deleted',
        'createFromClient',
    ];


    /**
     * getter method for 'index' method.
     *
     * is declared here to force the developer to rationally choose which elements to be shown
     *
     * @return Collection
     **/

    // public function getIndexElements()
    // {
    //     return $this->getModelClass()::all();
    // }

    /**
     * parameter that decides which fields to use inside index table
     **/
    //  public $indexFieldsGroups = ['index'];

    /**
     * parameter that decides if create button is available
     **/
    //  public $avoidCreateButton = true;

    public function getClient($client)
    {
        return Client::getProjectClassName()::find($client);
    }

    public function getClienthash($clienthash)
    {
        return $this->getModelClass()::find($clienthash);
    }

    public function createFromClient($client)
    {
        $client = $this->getClient($client);

        $hash = $this->getModelClass()::make();

        $hash->client_id = $client->getKey();
        $hash->save();

        Ukn::s(__('clients::hashes.createdForClient', ['client' => $client->getName()]));

        return $this->_edit($hash);
    }

    public function edit($clienthash)
    {
        $clienthash = $this->getClienthash($clienthash);

        return $this->_edit($clienthash);
    }

    public function getAfterUpdateRoute()
    {
        return $this->getModel()->getClient()->getShowUrl();
    }

    public function update(Request $request, $clienthash)
    {
        $clienthash = $this->getClienthash($clienthash);

        return $this->_update($request, $clienthash);
    }

    public function destroy($clienthash)
    {
        $clienthash = $this->getClienthash($clienthash);

        return $this->_destroy($clienthash);
    }

}

