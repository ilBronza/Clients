<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class DestinationFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
            'translationPrefix' => 'clients::fields',
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.seeName',

                'street' => 'flat',
                'number' => 'flat',
                'zip' => 'flat',
                'town' => 'flat',
                'city' => 'flat',
                'province' => 'flat',
                'region' => 'flat',
                'state' => 'flat',


                'client' => 'relations.belongsTo',
                'types' => 'relations.belongsToMany',

                'name' => 'flat',
                'plate' => 'flat',
                'registered_at' => 'flat',

                'initial_km' => 'flat',
                'current_km' => 'flat',

                'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}