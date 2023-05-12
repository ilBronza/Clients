<?php

namespace IlBronza\Clients\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDBelongsToManyTrait;
// use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDDestroyTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\CRUD\Traits\CRUDUpdateEditorTrait;
use IlBronza\Clients\Http\ParametersFile\Referent\CreateReferentParameters;
use IlBronza\Clients\Http\ParametersFile\Referent\EditReferentParameters;

use IlBronza\Clients\Models\Client;

use IlBronza\Ukn\Ukn;
use Illuminate\Http\Request;

class CrudReferentController extends CRUD
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

    public $avoidCreateButton = true;

    public static $tables = [

        'index' => [
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'client' => [
                    'type' => 'links.see',
                    'textParameter' => 'name'
                ],
                'destination' => [
                    'type' => 'links.see',
                    'textParameter' => 'name'
                ],

                'first_name' => 'flat',
                'second_name' => 'flat',
                'email' => 'flat',
                'phone' => 'flat',
                'types' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ],

        'related' => [
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',


                'first_name' => 'flat',
                'second_name' => 'flat',

                'types' => 'relations.belongsToMany',

                'email' => 'flat',
                'phone' => 'flat',

                'destination' => [
                    'type' => 'links.see',
                    'textParameter' => 'name'
                ],
                'destinations' => 'relations.belongsToMany',

                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    public $returnBack = true;

    public function setModelClass()
    {
        $this->modelClass = config('clients.models.referent.class');
    }

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('clients.routePrefix');
    }

    public function getModelClass() : string
    {
        return config('clients.models.referent.class');
    }

    // public $createParametersFile = CreateReferentParameters::class;
    public $editParametersFile = EditReferentParameters::class;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'show',
        'edit',
        'update',
        // 'create',
        // 'store',
        'destroy',
        'deleted',
        'createFromClient',
    ];

    /**
     * to override show view use full view name
     **/
    //public $showView = 'products.showPartial';

    // public $guardedEditDBFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
    // public $guardedCreateDBFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
    // public $guardedShowDBFields = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * relations called to be automatically shown on 'show' method
     **/
    //public $showMethodRelationships = ['posts', 'users', 'operations'];

    /**
        protected $relationshipsControllers = [
        'permissions' => '\IlBronza\AccountManager\Http\Controllers\PermissionController'
    ];
    **/


    /**
     * getter method for 'index' method.
     *
     * is declared here to force the developer to rationally choose which elements to be shown
     *
     * @return Collection
     **/

    public function getIndexElements()
    {
        return $this->getModelClass()::all();
    }

    /**
     * parameter that decides which fields to use inside index table
     **/
    //  public $indexFieldsGroups = ['index'];

    public function getClient($client)
    {
        return Client::getProjectClassName()::find($client);
    }

    public function getReferent(int|string $referent)
    {
        return $this->getModelClass()::find($referent);
    }

    /**
     * START base methods declared in extended controller to correctly perform dependency injection
     *
     * these methods are compulsorily needed to execute CRUD base functions
     **/
    public function show($referent)
    {
        $referent = $this->getReferent($referent);

        return $this->_show($referent);
    }

    public function createFromClient($client)
    {
        $client = $this->getClient($client);

        $referent = $this->getModelClass()::make();

        $referent->client_id = $client->getKey();
        $referent->first_name = $client->getName();
        $referent->save();

        Ukn::s(__('clients::referents.createdForClient', ['client' => $client->getName()]));

        return $this->_edit($referent);
    }

    public function edit($referent)
    {
        $referent = $this->getReferent($referent);

        return $this->_edit($referent);
    }

    public function getAfterUpdateRoute()
    {
        return $this->getModel()->getClient()->getShowUrl();
    }

    public function getAfterStoreRoute()
    {
        return $this->getModel()->getClient()->getShowUrl();
    }

    public function update(Request $request, $referent)
    {
        $referent = $this->getReferent($referent);

        return $this->_update($request, $referent);
    }

    public function destroy($referent)
    {
        $referent = $this->getReferent($referent);

        return $this->_destroy($referent);
    }

    /**
     * END base methods
     **/





}

