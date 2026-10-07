<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;
use IlBronza\Clients\Validation\ClientValidationRules;

class ClientCreateFieldsetsParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'base' => [
				'translationPrefix' => 'clients::fields',
				'fields' => [
					'name' => ['text' => 'string|required|max:255'],
					'slug' => [
						'type' => 'text',
						'rules' => 'string|nullable|max:255',
						'disabled' => true
					],
					'fiscal_name' => ['text' => 'string|nullable|max:255'],
					'fiscal_code' => ['text' => ClientValidationRules::fiscalIdentifier($this->getModel())],
					'vat' => ['text' => ClientValidationRules::fiscalIdentifier($this->getModel())],
					'sdi' => ['text' => 'string|nullable|regex:/^[A-Za-z0-9]{7}$/'],
                    'is_client' => ['booleanCheckbox' => 'boolean|nullable'],
                    'is_supplier' => ['booleanCheckbox' => 'boolean|nullable'],
					'categories' => [
						'type' => 'select',
						'multiple' => true,
						'mustBeSorted' => false,
						'rules' => 'array|nullable|exists:' . config('category.models.category.table') . ',id',
						'relation' => 'categories'
					],
				],
				'width' => ['large@m']
			],
			'styles' => [
				'translationPrefix' => 'clients::fields',
				'fields' => [
					'first_color' => ['color' => 'string|nullable|hex_color|max:8'],
					'second_color' => ['color' => 'string|nullable|hex_color|max:8'],
				],
				'width' => ['large@m'],
			]
		];
	}}
