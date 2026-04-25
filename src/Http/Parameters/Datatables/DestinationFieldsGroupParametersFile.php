<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class DestinationFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
        $result = [
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
                'rootFilecabinets' => 'filecabinet::filecabinets.filecabinetsStatus',

                'venue' => [
                    'type' => 'editor.toggle',
                    'nullable' => true,
                ],

                'client' => 'relations.belongsTo',
                'types' => 'relations.belongsToMany',
                'mySelfLatitude' => 'addresses::coordinates.latitude',
                'mySelfLongitude' => 'addresses::coordinates.longitude',

                'mySelfDelete' => 'links.delete'
            ]
        ];

        if(! config('addresses.usesGoogleCoordinates'))
        {
            unset($result['fields']['mySelfLatitude']);
            unset($result['fields']['mySelfLongitude']);
        }

        if(! config('addresses.usesFilesCabinets'))
        {
            unset($result['fields']['rootFilecabinets']);
        }

		return $result;
	}
}