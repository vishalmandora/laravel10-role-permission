<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $this->authorize('viewAny');

        return Employer::query()
            ->with(['company', 'owner', 'teams', 'campaigns'])
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
        $this->authorize('view', $employer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employer $employer)
    {
        $this->authorize('update', $employer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employer $employer)
    {
        $this->authorize('update', $employer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        $this->authorize('delete', $employer);
    }
}
