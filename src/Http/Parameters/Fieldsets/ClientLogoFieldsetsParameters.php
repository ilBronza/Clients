<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class ClientLogoFieldsetsParameters extends FieldsetParametersFile
{
	public const UPLOAD_RULES = 'image|mimes:jpg,jpeg,png,gif,webp|max:5120';
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
						'rules' => 'nullable|' . self::UPLOAD_RULES,
					],
				],
				'width' => ['medium@m'],
			],
		];
	}
}
