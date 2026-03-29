<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\Operators\Helpers\Companies\CompanySessionHelper;

use function config;
use function route;

class ClientIndexController extends ClientCRUD
{
	public $rowSelectCheckboxes = true;
	
	use CRUDPlainIndexTrait;
	use CRUDIndexTrait;

	public $allowedMethods = ['index'];

	public function getIndexFieldsArray()
	{
		//ClientIndexFieldsGroupParametersFile
		return config('clients.models.client.fieldsGroupsFiles.index')::getTracedFieldsGroup();
	}

	public function getRelatedFieldsArray()
	{
		return config('clients.models.client.fieldsGroupsFiles.related')::getTracedFieldsGroup();
	}

//	public function addPostFieldsToTable()
//	{
//		if(config('clients.userArea.enabled', false))
//			$this->getTable()->createPostButton([
//				'href' => app('clients')->route('clients.clienthashes.send'),
//				'text' => 'clients.sendHash',
//				'icon' => 'right-to-bracket'
//			]);
//	}

	public function getIndexElements()
	{
		ini_set('max_execution_time', '120');
		ini_set('memory_limit', '-1');

		CompanySessionHelper::exitFromCompany();

		$query = $this->getModelClass()::with([
			'categories',
			'defaultDestination.address',
			'categories',
			'referents',
			'contacts',
			'address'
		]);

		return $query->get();
	}

}
