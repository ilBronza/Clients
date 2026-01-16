<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class ClientEditFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
//			'logo' => [
//				'showLegend' => false,
//				'fields' => [],
//				'view' => [
//					'name' => 'crud::utilities.logo.logo',
//					'parameters' => [
//						'logoModelInstance' => $this->getModel()
//					]
//				],
//				'width' => ['medium@m']
//			],
            'base' => [
	            'translationPrefix' => 'clients::fields',
                'fields' => [
					// 'company_site_slug' => ['text' => 'string|nullable|max:8'],
                    'name' => ['text' => 'string|nullable|max:255'],
                    'slug' => [
                        'type' => 'text',
                        'rules' => 'string|nullable|max:255',
                        'disabled' => true
                    ],
                    'fiscal_name' => ['text' => 'string|nullable|max:255'],
                    'fiscal_code' => ['text' => 'string|nullable|max:255'],
	                'vat' => ['text' => 'string|nullable|max:255'],
	                'is_client' => ['booleanCheckbox' => 'boolean|nullable'],
	                'is_supplier' => ['booleanCheckbox' => 'boolean|nullable'],
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
	        'address' => [
		        'translationPrefix' => 'addresses::fields',
		        'fields' => [
			        'street' => ['text' => 'string|nullable|max:255'],
			        'number' => ['text' => 'string|nullable|max:255'],
			        'city' => ['text' => 'string|nullable|max:255'],
			        'zip' => ['text' => 'string|nullable|max:255'],
			        'province' => ['text' => 'string|nullable|max:255'],
			        'town' => ['text' => 'string|nullable|max:255'],
			        'region' => ['text' => 'string|nullable|max:255'],
			        'state' => ['text' => 'string|nullable|max:255'],
		        ],
		        'width' => ['large']
	        ],
	        'contacts' => [
				'fields' => [],
				'view' => [
					'name' => 'contacts::contacts._fetcherModelContacts',
					'parameters' => [
						'model' => $this->getModel()
					]
				],
				'width' => ['large']
			],
////	        'documents' => [
////		        'fields' => [],
////		        'view' => [
////			        'name' => 'filecabinet::fetchers._modelDossiersByCategory',
////			        'parameters' => [
////				        'categorySlug' => 'documenti-aziendali',
////				        'model' => $this->getModel()
////			        ]
////		        ],
////		        'width' => ['large']
////		        //				'fields' => $documentsFields,
////		        //				'width' => ['large']
////	        ],
	        'bank' => [
		        'showLegend' => false,
		        'fields' => [],
		        'view' => [
			        'name' => 'filecabinet::fetchers._modelDossierByForm',
			        'parameters' => [
				        'formSlug' => 'bank-account',
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

