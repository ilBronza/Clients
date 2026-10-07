<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\Operators\Helpers\Companies\CompanySessionHelper;
use IlBronza\Operators\Models\Operator;

use function config;

class ClientByOperatorController extends ClientIndexController
{
	public $allowedMethods = ['index'];

	public function getIndexFieldsArray()
	{
		//ClientByOperatorFieldsGroupParametersFile
		return config('clients.models.client.fieldsGroupsFiles.byOperator', config('clients.models.client.fieldsGroupsFiles.index'))::getTracedFieldsGroup();
	}

	public function getIndexElements()
	{
		$operator = Operator::gpc()::findOrFail(request()->operator);

		$query = $operator->clients()->with([
			'categories',
			'defaultDestination.address'
		]);

		return $query->get();
	}

}
