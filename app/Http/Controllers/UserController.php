<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __invoke()
    {
        return User::query()
            ->with(['roles', 'permissions', 'teams', 'companies', 'campaigns', 'messageTemplates', 'unlockedContacts'])
            ->get();
    }

    public function owners()
    {
        return User::query()
            ->role(ROLE_BUSINESS_OWNER)
            ->get();
    }

    public function users()
    {
        return User::query()
            ->role(ROLE_BUSINESS_USER)
            ->get();
    }
}
