<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Http\Controllers\Traits\ControllerLogoTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientLogoFieldsetsParameters;
use Illuminate\Http\Request;

class ClientLogoController extends ClientCRUD
{
	use ControllerLogoTrait;
	use CRUDEditUpdateTrait;

	public $allowedMethods = ['logoFetcher', 'logoUploadForm', 'logoUpdate'];

	public function getOverriddenEditParametersFile() : string
	{
		return ClientLogoFieldsetsParameters::class;
	}

	public function getUpdateModelAction() : string
	{
		return $this->getModel()->getKeyedRoute('logoUpdate');
	}

	public function getAfterUpdatedRedirectUrl() : string
	{
		return $this->getModel()->getEditUrl();
	}

	public function returnLogoImage()
	{
		return view('clients::utilities.logo._logo', [
			'modelInstance' => $this->modelInstance,
			'image' => $this->modelInstance->getLogoImageUrl(),
		]);
	}

	public function logoFetcher(string $client)
	{
		$this->modelInstance = $this->findModel($client);

		return $this->returnLogoImage();
	}

	public function logoUploadForm(string $client)
	{
		return $this->_edit($this->findModel($client));
	}

	public function logoUpdate(Request $request, string $client)
	{
		return $this->_update($request, $this->findModel($client));
	}
}
