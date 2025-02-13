<?php

namespace IlBronza\Clients\Providers\Helpers;

use Carbon\Carbon;
use IlBronza\AccountManager\Helpers\UserCreatorHelper;
use IlBronza\AccountManager\Models\Role;
use IlBronza\AccountManager\Models\User;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Clienthash;
use IlBronza\Clients\Models\Referent;
use IlBronza\Operators\Models\ClientOperator;

use IlBronza\Operators\Models\Operator;

use function count;
use function dd;
use function explode;
use function rand;

class ClientHashHelper
{
	public Client $company;
	public Clienthash $clienthash;
	public Operator $operator;

	public function setCompany($company) : static
	{
		$this->company = $company;

		return $this;
	}

	public function getClienthash() : Clienthash
	{
		return $this->clienthash;
	}

	public function getCompany() : Client
	{
		return $this->company;
	}

	public function getOperator() : Operator
	{
		return $this->operator;
	}

	public function createUserByEmail(string $email) : User
	{
		$pieces = explode('@', $email);

		return UserCreatorHelper::createBySlimParameters(
			$pieces[0],
			$pieces[1],
			$email,
			true
		);
	}

	public function createOperatorByEmail(string $email)
	{
		if(! $user = User::gpc()::where('email', $email)->first())
			$user = $this->createUserByEmail($email);

		$administrativeRole = Role::gpc()::getCompanyAdministrativeRole();

		if(! $this->operator = $user->operator()->first())
			$this->operator = $user->createOperator();

		if(! ClientOperator::gpc()::where('operator_id', $this->operator->id)->where('client_id', $this->getCompany()->getKey())->where('role_id', $administrativeRole->getKey())->first())
		{
			$clientOperator = ClientOperator::gpc()::make();

			$clientOperator->operator_id = $this->operator->getKey();
			$clientOperator->client_id = $this->getCompany()->getKey();
			$clientOperator->role_id = $administrativeRole->getKey();

			$clientOperator->save();
		}
	}

	public function generateOperator()
	{
		dd('capire come trovare un utente valido e poi chiamare l\'ultimo metodo $this->createOperatorByEmail($email)');
		$company = $this->getCompany();

		$referents = Referent::gpc()::where('client_id', $company->getKey())->get();

		if(count($referents) > 0)
			dd('scegliere qua un operatore da impostare come manager');

		$clientOperators = ClientOperator::gpc()::where('client_id', $company->getKey())->get();

		if(count($clientOperators) > 0)
			dd('scegliere qua un operatore da impostare come manager');

		dd('scegliere un utente di qualche tipo');



		$this->createOperatorByEmail($email);
	}

	public function deletedPreviousHashes()
	{
		Clienthash::gpc()::where('client_id', $this->getCompany()->getKey())->where('operator_id', $this->getOperator()->getKey())->forceDelete();
	}

	public function generateClienthash()
	{
		$this->deletedPreviousHashes();

		$this->hash = Clienthash::make();

		$this->hash->client_id = $this->getCompany()->getKey();
		$this->hash->operator_id = $this->getOperator()->getKey();
		$this->hash->valid_to = Carbon::now()->addHours(12);

		$this->hash->save();
	}

	static function sendByCompany(Client $company) : static
	{
		$helper = new static();

		$helper->setCompany($company);

		$helper->generateOperator();

		$helper->generateClienthash();

		dd('mandaloh via emailh');

		$helper->sendClienthash();

		return $helper;
	}
}