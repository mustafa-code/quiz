<?php

namespace App\Services;

use App\Models\Tenant;

class TenantService
{
    public function forLookup($tenants)
    {
        return $tenants->map(function ($tenant) {
            return [
                'id' => $tenant->id,
                'name' => $tenant->name . "( {$tenant->domains()->first()?->domain} )",
            ];
        });
    }
}
