<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DestinationReferent extends Pivot
{
	static $packageConfigPrefix = 'clients';
	public ? string $translationFolderPrefix = 'clients';
	static $modelConfigPrefix = 'destinationReferent';
	public $timestamps = false;
	public $incrementing = true;

	use PackagedModelsTrait;

	public function referent()
	{
		return $this->belongsTo(
			config('clients.models.referent.class')
		);
	}

	public function destination()
	{
		return $this->belongsTo(
			config('clients.models.destination.class')
		);
	}

}
