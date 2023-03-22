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
            ->role('Business-Owner')
            ->get();
    }

    public function users()
    {
        return User::query()
            ->role('Business-User')
            ->get();
    }
}
