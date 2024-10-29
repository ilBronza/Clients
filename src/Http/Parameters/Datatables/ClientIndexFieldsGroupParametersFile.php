<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class ClientIndexFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
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
        ];
	}
}