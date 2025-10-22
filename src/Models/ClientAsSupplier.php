<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\Scopes\AsSupplierScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([AsSupplierScope::class])]
class ClientAsSupplier extends Client
{
	public $routeClassname = 'client';

	public function getForeignKey()
	{
		return 'client_id';
	}
}