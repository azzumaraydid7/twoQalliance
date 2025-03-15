<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyFormRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Company/Index', [
            'companies' => Company::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyFormRequest $request): RedirectResponse
    {
        Company::create($request->validated());

        if(Auth::guard('admin')->check()) {
            return redirect()->intended(route('company.admin.index', absolute: false));
        } else {
            return redirect()->intended(route('company.index', absolute: false));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Company/Edit', [
            'company' => Company::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyFormRequest $request, string $id): RedirectResponse
    {
        Company::find($id)->update($request->validated());
        
        if(Auth::guard('admin')->check()) {
            return Redirect::route('company.admin.edit', ['id' => $id]);
        } 

        return Redirect::route('company.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
