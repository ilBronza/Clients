<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

/** Destinations displayed under their owning client. */
class DestinationRelatedByOwnerFieldsGroupParametersFile extends DestinationFieldsGroupParametersFile
{
    static function getFieldsGroup() : array
    {
        $parameters = parent::getFieldsGroup();

        unset($parameters['fields']['client']);

        return $parameters;
    }
}
