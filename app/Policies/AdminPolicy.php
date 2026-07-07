<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Determine whether the user can access admin dashboard/routes.
     */
    public function viewAdmin(User $user): bool
    {
        return $user->isAdmin();
    }
}
