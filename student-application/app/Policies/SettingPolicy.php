<?php

// app/Policies/SettingPolicy.php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function manageSettings(User $user)
    {
        return $user->hasRole('admin'); // Assuming you're using roles
    }
}