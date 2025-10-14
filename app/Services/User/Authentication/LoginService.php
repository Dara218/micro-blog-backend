<?php

namespace App\Services\User\Authentication;

use App\Enums\UserGuard;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Handles the user login process.
     *
     * @param array<mixed, string> $loginDetails
     *
     * @return bool
     */
    public function handleLoginProcess($loginDetails): bool
    {
        $guard = UserGuard::USER->value;

        if (!Auth::guard($guard)->attempt($loginDetails)) {
            return false;
        }

        return true;
    }
}
