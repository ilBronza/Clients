<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class ClientRelatedFieldsGroupParametersFile extends FieldsGroupParametersFile
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

                'name' => 'flat',
                'fiscal_name' => 'flat',
                'fiscal_code' => 'flat',
                'vat' => 'flat',

                'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}