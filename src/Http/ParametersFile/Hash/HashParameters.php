<?php

namespace IlBronza\Clients\Http\ParametersFile\Hash;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class HashParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'general' => [
                'translationPrefix' => 'clients::fields',
                'fields' => [
                    'valid_to' => ['datetime' => 'date|nullable'],
                    'permanent' => ['boolean' => 'boolean|required'],
                ]
            ]
        ];
    }
}

