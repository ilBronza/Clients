<?php

namespace IlBronza\Clients\Http\Controllers\Referents;

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
use IlBronza\Clients\Http\ParametersFile\CrudReferenttypeParameters;
use IlBronza\Clients\Models\Referenttype;
use IlBronza\Ukn\Facades\Ukn;
use Illuminate\Http\Request;

class CrudReferenttypeController extends CRUD
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

    public $parametersFile = CrudReferenttypeParameters::class;

    public function setModelClass()
    {
        $this->modelClass = config('clients.models.referenttype.class');
    }

    public static $tables = [

        'index' => [
            'fields' => 
            [
                'name' => 'flat',
                'slug' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ],
        'related' => [
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
    public $modelClass = Referenttype::class;
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

    public function getReferenttype(int|string $referenttype)
    {
        return $this->getModelClass()::find($referenttype);
    }

    public function show(int|string $referenttype)
    {
        $referenttype = $this->getReferenttype($referenttype);

        return $this->_show($referenttype);
    }

    public function edit(int|string $referenttype)
    {
        $referenttype = $this->getReferenttype($referenttype);

        return $this->_edit($referenttype);
    }

    public function update(Request $request, int|string $referenttype)
    {
        $referenttype = $this->getReferenttype($referenttype);

        return $this->_update($request, $referenttype);
    }

    public function destroy(int|string $referenttype)
    {
        $referenttype = $this->getReferenttype($referenttype);

        return $this->_destroy($referenttype);
    }
}

