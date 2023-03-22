<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Employer::class, 'employer');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Employer::query()
            ->with(['company', 'owner', 'teams', 'campaigns', 'messageTemplates'])
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employer $employer)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employer $employer)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
    }
}
