<?php

namespace App\Http\Controllers;

use App\Models\UnlockedContact;

class UnlockedContactController extends Controller
{
    public function __invoke()
    {
        return UnlockedContact::query()->get();
    }
}
