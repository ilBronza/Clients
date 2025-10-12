<?php

namespace IlBronza\Clients\Http\ParametersFile\Client;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class ShowClientParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'registry' => [
                'translationPrefix' => 'clients::fields',
                'fields' => [
                    'name' => ['text' => 'string|nullable|max:255'],
                    'slug' => [
                        'type' => 'text',
                        'rules' => 'string|nullable|max:255',
                        'disabled' => true
                    ],
                    'fiscal_name' => ['text' => 'string|required|max:255'],
                    'fiscal_code' => ['text' => 'string|nullable|max:255'],
                    'is_client' => ['booleanCheckbox' => 'boolean|nullable'],
                    'is_supplier' => ['booleanCheckbox' => 'boolean|nullable'],
                ],
                'width' => ['1-2@m']
            ]
        ];
    }
}

