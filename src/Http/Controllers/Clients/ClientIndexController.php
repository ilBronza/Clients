<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

use function config;

class ClientIndexController extends ClientCRUD
{
	use CRUDPlainIndexTrait;
	use CRUDIndexTrait;

	public $allowedMethods = ['index'];

	public function getIndexFieldsArray()
	{
		//ClientIndexFieldsGroupParametersFile
		return config('clients.models.client.fieldsGroupsFiles.index')::getFieldsGroup();
	}

	public function getRelatedFieldsArray()
	{
		return config('clients.models.client.fieldsGroupsFiles.related')::getFieldsGroup();
	}

	public function getIndexElements()
	{
		ini_set('max_execution_time', '120');
		ini_set('memory_limit', '-1');

		$query = $this->getModelClass()::with([
			'categories',
			'defaultDestination.address',
			'categories'
		]);

		return $query->get();
	}

}
