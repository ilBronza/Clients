<?php

namespace IlBronza\Clients\Http\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

/** Referents displayed under their owning client. */
class ReferentRelatedByOwnerFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup() : array
    {
        return [
            'translationPrefix' => 'clients::fields',
            'fields' => [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'first_name' => 'flat',
                'second_name' => 'flat',
                'types' => 'relations.belongsToMany',
                'email' => 'flat',
                'phone' => 'flat',
                'destination' => [
                    'type' => 'links.see',
                    'textParameter' => 'name',
                ],
                'destinations' => 'relations.belongsToMany',
                'mySelfDelete' => 'links.delete',
            ],
        ];
    }
}
