<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Models\Media;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationCRUD;

class DestinationDeleteMediaController extends DestinationCRUD
{
    public $allowedMethods = ['deleteMedia'];

    public function deleteMedia($destination, Media $media)
    {
        $model = $this->findModel($destination);

        abort_unless($model, 404);
        abort_unless($model->userCanDelete(), 403);

        abort_unless($model->is($media->model), 403);
        $media->delete();

        return ['success' => true];
    }
}
