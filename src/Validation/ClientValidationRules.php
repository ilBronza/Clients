<?php

namespace IlBronza\Clients\Validation;

use Illuminate\Database\Eloquent\Model;

class ClientValidationRules
{
    public static function fiscalIdentifier(?Model $model = null) : string
    {
        $rules = 'string|nullable|max:255';

        if (config('clients.validation.rejectDuplicateFiscalIdentifiers', true)) {
            $rules .= '|clients_unique_fiscal';

            if ($model?->exists) {
                $rules .= ':' . $model->getKey();
            }
        }

        return $rules;
    }
}
