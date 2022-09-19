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

    static $formFields = [
        'common' => [
            'default' => [
                'name' => ['text' => 'string|required|max:255'],
                'slug' => ['text' => 'string|nullable|max:255'],
                'fiscal_name' => ['text' => 'string|nullable|max:255'],
                'fiscal_code' => ['text' => 'string|nullable|max:255'],
                'vat' => ['text' => 'string|nullable|max:255'],
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

    /**
     * subject model class full path
     **/
    public $modelClass = Client::class;

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
        'stroreReorder'
    ];

    /**
     * to override show view use full view name
     **/

    public $relationshipsManagerClass = ClientRelationManager::class;

    public function getExtendedShowButtons()
    {
        $this->showButtons[] = $this->modelInstance->getCreateDestinationButton();
        $this->showButtons[] = $this->modelInstance->getCreateReferentButton();
    }

    public function getIndexElements()
    {
        return Client::all();
    }

    public function show(Client $client)
    {
        return $this->_show($client);
    }

    public function edit(Client $client)
    {
        return $this->_edit($client);
    }

    public function update(Request $request, Client $client)
    {
        return $this->_update($request, $client);
    }

    public function destroy(Client $client)
    {
        return $this->_destroy($client);
    }
}

