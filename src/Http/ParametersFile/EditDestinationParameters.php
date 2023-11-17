<?php

namespace IlBronza\Clients\Http\ParametersFile;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class EditDestinationParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'personal_data' => [
                'translationPrefix' => 'clients::fields',
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
                'translationPrefix' => 'clients::fields',
                'fields' => [
                    'client' => [
                        'type' => 'select',
                        'multiple' => false,
                        'disabled' => true,
                        'rules' => 'string|required|exists:' . config('clients.models.client.table') . ',id',
                        'relation' => 'client'
                    ],
                    'destination' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|nullable|exists:' . config('clients.models.destination.table') . ',id',
                        'relation' => 'destination'
                    ],
                    'destinations' => [
                        'type' => 'select',
                        'multiple' => true,
                        'rules' => 'array|nullable|exists:' . config('clients.models.destination.table') . ',id',
                        'relation' => 'destinations'
                    ],
                    'types' => [
                        'type' => 'select',
                        'multiple' => true,
                        'rules' => 'array|nullable|exists:' . config('clients.models.destinationtype.table') . ',slug',
                        'relation' => 'types'
                    ],
                ],
                'width' => ['1-2@m']
            ],
        ];
    }
}

