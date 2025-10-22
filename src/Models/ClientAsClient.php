<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\Scopes\AsClientScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([AsClientScope::class])]
class ClientAsClient extends Client
{
	// public $routeBasename = 'ibProductsorderrows';
	public $routeClassname = 'client';

	public function getForeignKey()
	{
		return 'client_id';
	}
}