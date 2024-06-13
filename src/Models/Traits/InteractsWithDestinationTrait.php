<?php

namespace IlBronza\Clients\Models\Traits;

use IlBronza\Clients\Models\Destination;

trait InteractsWithDestinationTrait
{
	public function destination()
	{
		return $this->belongsTo(Destination::getProjectClassName());
	}

    public function getDestination() : ? Destination
    {
        if(! $this->destination_id)
            return null;

        if($this->relationLoaded('destination'))
            return $this->destination;

        return Destination::getProjectClassName()::findCached($this->destination_id);
    }

}