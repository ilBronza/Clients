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
                'mySelfSee' => [
					'type' => 'links.seeName',
	                'width' => '255px'
                ],

                'street' => 'flat',
                'number' => 'flat',
                'zip' => 'flat',
                'town' => 'flat',
                'city' => 'flat',
                'province' => 'flat',
                'region' => 'flat',
                'state' => 'flat',

	            'venue' => [
					'type' => 'editor.toggle',
		            'nullable' => true,
	            ],

                'client' => 'relations.belongsTo',
                'types' => 'relations.belongsToMany',

                'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}