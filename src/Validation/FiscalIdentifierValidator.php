<?php

namespace IlBronza\Clients\Validation;

use IlBronza\Clients\Models\Client;

class FiscalIdentifierValidator
{
    public function validate(string $attribute, mixed $value, array $parameters) : bool
    {
        if (! in_array($attribute, ['vat', 'fiscal_code'], true) || ! is_string($value)) {
            return false;
        }

        $value = $attribute === 'vat' ? Client::normalizeVat($value) : strtoupper(trim($value));

        if ($value === null || $value === '') {
            return true;
        }

        // Uniqueness applies across the registry, including clients hidden by user scopes.
        $query = Client::gpc()::withoutGlobalScopes()->whereNull('deleted_at');
        $column = $query->getQuery()->getGrammar()->wrap($attribute);
        $query->whereRaw("UPPER(TRIM({$column})) = ?", [$value]);

        if (isset($parameters[0])) {
            $query->whereKeyNot($parameters[0]);
        }

        return ! $query->exists();
    }
}
