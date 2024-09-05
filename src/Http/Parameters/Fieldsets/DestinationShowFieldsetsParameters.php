<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class DestinationShowFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'default' => [
                'translationPrefix' => 'clients::fields',
                'fields' => [
                    'client_id' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|nullable|exists:clients__clients,id',
                        'relation' => 'client',
                        'disabled' => true
                    ],
					'name' => ['text' => 'string|nullable|max:255'],
					'venue' => ['boolean' => 'boolean|nullable'],
                    'types' => [
                        'type' => 'select',
                        'multiple' => true,
                        // 'select2' => false,
                        'rules' => 'array|nullable|exists:' . config('clients.models.destinationtype.table') . ',slug',
                        'relation' => 'types'
                    ],
                    'referents' => [
                        'type' => 'select',
                        'multiple' => true,
                        // 'select2' => false,
                        'rules' => 'array|nullable|exists:' . config('clients.models.referent.table') . ',slug',
                        'relation' => 'referents'
                    ],
                ],
                'width' => ['xlarge@m']
            ],
            'address' => [
                'translationPrefix' => 'addresses::fields',
                'fields' => [
                    'street' => ['text' => 'string|nullable|max:255'],
                    'number' => ['text' => 'string|nullable|max:255'],
                    'zip' => ['text' => 'string|nullable|max:255'],
                    'town' => ['text' => 'string|nullable|max:255'],
                    'city' => ['text' => 'string|nullable|max:255'],
                    'province' => ['text' => 'string|nullable|max:255'],
                    'region' => ['text' => 'string|nullable|max:255'],
                    'state' => ['text' => 'string|nullable|max:255'],
                ],
                'width' => ['xlarge@m']
            ]
        ];
    }
}

