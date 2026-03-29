<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class DestinationCreateStoreFieldsetsParameters extends DestinationShowFieldsetsParameters
{
    public function _getFieldsetsParameters() : array
    {
        $parameters = parent::_getFieldsetsParameters();

        unset($parameters['general']['fields']['emotional_image']);

        return $parameters;
    }
}