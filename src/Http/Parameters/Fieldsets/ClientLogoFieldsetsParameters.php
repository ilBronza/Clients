<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class ClientLogoFieldsetsParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'logo' => [
				'translationPrefix' => 'clients::fields',
				'fields' => [
					'logo' => [
						'type' => 'file',
						'collection' => 'logo',
						'persist' => false,
						'multiple' => false,
						'disk' => [
							'method' => 'getLogoDisk',
						],
						'rules' => 'file|nullable|max:5120',
					],
				],
				'width' => ['medium@m'],
			],
		];
	}
}
