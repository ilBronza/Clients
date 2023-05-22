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

use IlBronza\Clients\Http\ParametersFile\Client\ShowClientParameters;
use IlBronza\Clients\Providers\RelationshipsManagers\ClientRelationManager;

use Illuminate\Http\Request;

class CrudClientController extends CRUD
{
    public static $tables = [

        'index' => [
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'name' => 'flat',
                'slug' => 'flat',
                'fiscal_name' => 'flat',
                'fiscal_code' => 'flat',
                'vat' => 'flat',
                'destinations' => 'relations.hasMany',
                'referents' => 'relations.hasMany',
                'created_at' => 'dates.datetime',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

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

    public function setModelClass()
    {
        $this->modelClass = config('clients.models.client.class');
    }

    // public function getModelClass() : string
    // {
    //     return config('clients.models.client.class');
    // }

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('clients.routePrefix');
    }

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
        'deleted',
        'archived',
        'storeReorder'
    ];

    /**
     * to override show view use full view name
     **/

    public $relationshipsManagerClass = ClientRelationManager::class;

    public function getExtendedShowButtons()
    {
        $this->showButtons[] = $this->modelInstance->getCreateDestinationButton();
        $this->showButtons[] = $this->modelInstance->getCreateReferentButton();
        $this->showButtons[] = $this->modelInstance->getCreateHashButton();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::with('destinations.types', 'referents.types')->get();
    }

    public function getClient(int|string $client)
    {
        return $this->getModelClass()::find($client);
    }

    public function show($client)
    {
        $client = $this->getClient($client);
        return $this->_show($client);
    }

    public function edit($client)
    {
        $client = $this->getClient($client);
        return $this->_edit($client);
    }

    public function update(Request $request, $client)
    {
        $client = $this->getClient($client);
        return $this->_update($request, $client);
    }

    public function destroy($client)
    {
        $client = $this->getClient($client);
        return $this->_destroy($client);
    }
}

