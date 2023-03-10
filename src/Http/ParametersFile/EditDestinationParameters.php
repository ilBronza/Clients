<?php

namespace IlBronza\Clients\Http\ParametersFile;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class EditDestinationParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'personal_data' => [
                'translatedLegend' => __('clients::destinations.personalData'),
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
                        'disabled' => true,
                        'rules' => 'string|required|exists:clients,id',
                        'relation' => 'client'
                    ],
                    'destination' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|nullable|exists:destinations,id',
                        'relation' => 'destination'
                    ],
                    'destinations' => [
                        'type' => 'select',
                        'multiple' => true,
                        'rules' => 'array|nullable|exists:destinations,id',
                        'relation' => 'destinations'
                    ],
                    'type' => ['text' => 'string|required|max:255'],
                ],
                'width' => ['1-2@m']
            ],
        ];
    }
}

