<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamController extends Controller
{
    public function __invoke()
    {
        return Team::query()
            ->with(['users', 'employer'])
            ->get();
    }
}
