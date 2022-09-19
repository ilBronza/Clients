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
use IlBronza\Clients\Models\Referent;
use Illuminate\Http\Request;

class CrudReferentController extends CRUD
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
                'type' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    static $formFields = [
        'common' => [
            'default' => [
                'client' => [
                    'type' => 'select',
                    'multiple' => false,
                    'rules' => 'string|required|exists:clients,id',
                    'relation' => 'client'
                ],
                'destination' => [
                    'type' => 'select',
                    'multiple' => false,
                    'rules' => 'string|nullable|exists:destinations,id',
                    'relation' => 'destination'
                ],
                'first_name' => ['text' => 'string|nullable|max:255'],
                'second_name' => ['text' => 'string|nullable|max:255'],
                'email' => ['text' => 'string|required|max:255'],
                'phone' => ['text' => 'string|nullable|max:255'],

                'type' => ['text' => 'string|required|max:255'],
            ],
        ],
    ];    

    public $returnBack = true;

    /**
     * subject model class full path
     **/
    public $modelClass = Referent::class;

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
        'reorder',
        'createFromClient',
        'stroreReorder'
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
        return Referent::all();
    }

    /**
     * parameter that decides which fields to use inside index table
     **/
    //  public $indexFieldsGroups = ['index'];

    /**
     * parameter that decides if create button is available
     **/
    //  public $avoidCreateButton = true;



    /**
     * START base methods declared in extended controller to correctly perform dependency injection
     *
     * these methods are compulsorily needed to execute CRUD base functions
     **/
    public function show(Referent $referent)
    {
        return $this->_show($referent);
    }

    public function createFromClient(Client $client)
    {
        $referent = Referent::make();
        $referent->client_id = $client->getKey();
        $referent->first_name = $client->getName();
        $referent->save();

        return $this->edit($referent);
    }

    public function edit(Referent $referent)
    {
        return $this->_edit($referent);
    }

    public function update(Request $request, Referent $referent)
    {
        return $this->_update($request, $referent);
    }

    public function destroy(Referent $referent)
    {
        return $this->_destroy($referent);
    }

    /**
     * END base methods
     **/




     /**
      * START CREATE PARAMETERS AND METHODS
      **/

    // public function beforeRenderCreate()
    // {
    //     $this->modelInstance->agent_id = session('agent')->getKey();
    // }

     /**
      * STOP CREATE PARAMETERS AND METHODS
      **/

}

