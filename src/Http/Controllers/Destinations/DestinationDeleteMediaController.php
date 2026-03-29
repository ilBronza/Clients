<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Models\Media;
use IlBronza\CRUD\Traits\CRUDDeleteMediaTrait;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationCRUD;

class DestinationDeleteMediaController extends DestinationCRUD
{
    use CRUDDeleteMediaTrait;

    public $allowedMethods = ['deleteMedia'];

    public function deleteMedia($packing, Media $media)
    {
        return $this->_deleteMedia($packing, $media);
    }
}
