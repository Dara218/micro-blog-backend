<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get the authenticate user.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getAuthUser(Request $request)
    {
        return response([
            'success' => true,
            'user' => $request->user(),
        ]);
    }
}
