<?php

namespace IlBronza\Clients\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use function dd;

class ClientAreaManagerScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 */
	public function apply(Builder $builder, Model $model) : void
	{
		if(! auth()->user()?->hasRole('areaManager'))
			return ;

		$builder->forAreaManagers();
	}
}
