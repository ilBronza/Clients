<?php

namespace IlBronza\Clients\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ClientAreaManagerScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 */
	public function apply(Builder $builder, Model $model) : void
	{
		if(! auth()->user()?->hasRole('areaManager'))
			return ;

		if ($model->hasNamedScope('forAreaManagers')) {
			$builder->forAreaManagers();
			return;
		}

		// Applications define their area assignment rules on the configured Client model.
		// Without those rules, never expose the entire registry to an area manager.
		$builder->whereRaw('1 = 0');
	}
}
