<?php

namespace IlBronza\Clients\Http\ParametersFile\Referent;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class CreateReferentParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'personal_data' => [
                'translatedLegend' => __('clients::referents.personalData'),
                'fields' => [
                    'first_name' => ['text' => 'string|nullable|max:255'],
                    'second_name' => ['text' => 'string|nullable|max:255'],
                    'email' => ['text' => 'string|required|max:255'],
                    'phone' => ['text' => 'string|nullable|max:255'],
                ],
                'width' => ['1-2@m']
            ],
            'general' => [
                'fields' => [
                    'client' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|required|exists:clients,id',
                        'relation' => 'client'
                    ],
                    'type' => ['text' => 'string|required|max:255'],                
                ],
                'width' => ['1-2@m']
            ],
        ];
    }
}

