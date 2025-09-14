<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserRole
{
    public function role()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->roles && $user->roles->isNotEmpty()) {
                return $user->roles->first()->name;
            }

            return 'No Role Assigned';
        }
        return 'Unauthorize';
    }
}
