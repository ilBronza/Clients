<?php

namespace IlBronza\Clients\Http\ParametersFile;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class CrudDestinationtypeParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'general' => [
                'translationPrefix' => 'clients::fields',
                'fields' => [
                    'name' => ['text' => 'string|required|max:255']
                ],
                'width' => ['1-2@m']
            ],
        ];
    }
}

