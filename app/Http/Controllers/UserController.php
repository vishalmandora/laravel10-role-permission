<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __invoke()
    {
        return User::query()
            ->with('roles', 'permissions', 'teams')
            ->get();
    }
}
