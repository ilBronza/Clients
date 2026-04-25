<?php

namespace IlBronza\Clients\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;

/**
 * Resolves allowed roles for Clients routes from config (clients.defaultRoles / clients.routeRoles).
 */
class ClientsMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'clients';
}
