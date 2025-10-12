<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class ClientCreateFieldsetsParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'base' => [
				'translationPrefix' => 'clients::fields',
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
			]
		];
	}}

