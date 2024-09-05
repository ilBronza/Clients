<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class ClientEditFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
			'logo' => [
				'showLegend' => false,
				'fields' => [],
				'view' => [
					'name' => 'crud::utilities.logo.logo',
					'parameters' => [
						'logoModelInstance' => $this->getModel()
					]
				],
				'width' => ['medium@m']
			],
            'base' => [
                'fields' => [
                    'name' => ['text' => 'string|nullable|max:255'],
                    'slug' => [
                        'type' => 'text',
                        'rules' => 'string|nullable|max:255',
                        'disabled' => true
                    ],
                    'fiscal_name' => ['text' => 'string|nullable|max:255'],
                    'fiscal_code' => ['text' => 'string|nullable|max:255'],
                    'vat' => ['text' => 'string|nullable|max:255'],
                    'categories' => [
                        'type' => 'select',
                        'multiple' => true,
                        'mustBeSorted' => false,
                        'rules' => 'nullable|exists:' . config('category.models.category.table') . ',id',
                        'relation' => 'categories'
                    ],
                ],
                'width' => ['large@m']
            ],
			'contacts' => [
				'showLegend' => false,
				'fields' => [],
				'view' => [
					'name' => 'contacts::contacts._fetcherModelContacts',
					'parameters' => [
						'model' => $this->getModel()
					]
				],
				'width' => ['medium']
			],
			'documents' => [
				'fields' => [],
				'view' => [
					'name' => 'filecabinet::fetchers._modelDossiersByCategory',
					'parameters' => [
						'categorySlug' => 'documenti-aziendali',
						'model' => $this->getModel()
					]
				],
				'width' => ['large']
				//				'fields' => $documentsFields,
				//				'width' => ['large']
			],
			'notes' => [
				'fields' => [],
				'view' => [
					'name' => 'notes::notes',
					'parameters' => [
						'modelInstance' => $this->getModel(),
					],
				],
				'width' => ['xlarge']
			],

		];
    }
}

