<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TenantPolicy
{

    /**
     * Determine if the given tenant is owned by the user.
     *
     * @param  \App\Models\User  $user
     * @return Response|bool
     */
    public function ownsTenant(User $user, Tenant $tenant)
    {
        return $user->id === $tenant->user_id;
    }

    public function update(User $user, Tenant $tenant)
    {
        return $user->id === $tenant->user_id;
    }

}
