<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function manageApplications(User $user)
    {
        // Add your authorization logic here
        return $user->hasRole('admin') || $user->hasPermission('manage-applications');
    }
}