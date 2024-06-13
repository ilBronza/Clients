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
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientEditFieldsetsParameters;
use IlBronza\Clients\Providers\RelationshipsManagers\ClientRelationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CrudClientController extends CRUD
{
    public $configModelClassName = 'client';

    public static $tables = [

        'index' => [
            'translationPrefix' => 'clients::fields',
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'name' => 'flat',
                'slug' => 'flat',
                'categories' => 'relations.belongsToMany',
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

    public $parametersFile = ClientEditFieldsetsParameters::class;


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

    public function getExtendedShowButtons()
    {
        if(app('clients')->hasDestinations())
            $this->showButtons[] = $this->modelInstance->getCreateDestinationButton();

        if(app('clients')->hasReferents())
            $this->showButtons[] = $this->modelInstance->getCreateReferentButton();

        if(app('clients')->hasClientPrivateArea())
            $this->showButtons[] = $this->modelInstance->getCreateHashButton();
    }

    public function getRelationshipsManagerClass()
    {
        return config("clients.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    }

    public function getModelLoadingRelations() : array
    {
        return $this->getModelClass()::getAutomaticCachingRelationships();
    }

    public function _getIndexElements(Collection|array $missingIds = null)
    {
        if((is_array($missingIds))&&(count($missingIds) == 0))
            return collect();

        // $query = $this->getModelClass()::with(
        //     $this->getModelLoadingRelations()
        // );

        $query = $this->getModelClass()::with([
            'categories',
            'destinations',
            'referents'
        ]);

        if($missingIds)
            $query->whereIn('id', $missingIds);

        return $query->get();
    }

    public function getIndexElements()
    {
        ini_set('max_execution_time', '120');
        ini_set('memory_limit', "-1");

        // if($this->modelHasAutomaticCache())
        //     return $this->getCachedIndexElements();

        return $this->_getIndexElements();
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

