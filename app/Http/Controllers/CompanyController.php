<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function __invoke()
    {
        return Company::query()
            ->with(['users', 'employers'])
            ->get();
    }
}
