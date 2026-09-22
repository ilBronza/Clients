<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class ClientIndexFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
			'translationPrefix' => 'clients::fields',
			'fields' => [
				'mySelfPrimary' => 'primary',
				'mySelfEdit' => 'links.edit',
				'mySelfSee' => 'links.see',
				'name' => 'flat',
				'first_color' => 'editor.color',
				'second_color' => 'editor.color',
				'categories' => 'relations.belongsToMany',
				'cost_coefficient' => 'editor.numeric',
				'fiscal_name' => 'flat',
				'fiscal_code' => 'flat',
				'vat' => 'flat',
				'address.street' => 'flat',
				'address.city' => 'flat',
				'address.province' => 'flat',
				'address.state' => 'flat',
				//	            'destinations' => 'relations.hasMany',
				'referents' => 'relations.hasMany',
				'mySelfDelete' => 'links.delete'
			]
		];
	}
}
