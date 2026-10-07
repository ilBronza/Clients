<?php

namespace IlBronza\Clients\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Resolves allowed roles for Clients routes from config (clients.defaultRoles / clients.routeRoles).
 */
class ClientsMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'clients';

    protected function getRolesForCurrentRoute(Request $request): array
    {
        $routeName = $request->route()?->getName();
        $overrides = config('clients.routeRoles', []);

        if ($routeName && Arr::has($overrides, $routeName)) {
            // An explicit empty list denies access instead of reverting to the default roles.
            return $this->normalizeRoles(Arr::get($overrides, $routeName));
        }

        return $this->normalizeRoles(config('clients.defaultRoles', []));
    }
}
