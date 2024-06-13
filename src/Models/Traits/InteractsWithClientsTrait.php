<?php

namespace IlBronza\Clients\Models\Traits;

use IlBronza\Clients\Models\Client;

trait InteractsWithClientsTrait
{
    public function client()
    {
        return $this->belongsTo(Client::getProjectClassName());
    }

    public function getClient() : ? Client
    {
        if(! $this->client_id)
            return null;

        if($this->relationLoaded('client'))
            return $this->client;

        return Client::getProjectClassName()::findCached($this->client_id);
    }

	
}