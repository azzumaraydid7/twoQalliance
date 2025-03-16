<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyFormRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->limit(10)->get()->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
                'logo' => $company->logo ? asset('storage/' . $company->logo) : null,
                'website_link' => $company->website_link,
            ];
        });

        return Inertia::render('Company/Index', [
            'companies' => $companies
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
        try {
            $data = $request->validated();
            
            if($request->logo) {
                $path = storage_path('app/public/company/logo/');
    
                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
    
                if (File::exists($path)) {
                    $data['logo'] = $request->file('logo')->store('company/logo', 'public');
                }
            }
    
            Company::create($data);
        } catch (\Exception $e) {
            Log::error($e);
        }

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
        $company = Company::find($id);

        $company = [
            'id' => $company->id,
            'name' => $company->name,
            'email' => $company->email,
            'logo' => $company->logo ? asset('storage/' . $company->logo) : null,
            'website_link' => $company->website_link,
        ];

        return Inertia::render('Company/Edit', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'website_link' => 'required',
        ];

        try {
            $company = Company::find($id);

            if($company) {
                $validator = Validator::make($data, $rules);
                
                if(!$validator->fails() && $request->logo) {
                    $path = storage_path('app/public/company/logo/');
        
                    if (! File::exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
        
                    if (File::exists($path) && $request->file('logo')) {
                        $data['logo'] = $request->file('logo')->store('company/logo', 'public');
                    } else {
                        $data['logo'] = $company->logo;
                    }
                }
        
                $company->update($data);
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
        
        if(Auth::guard('admin')->check()) {
            return Redirect::route('company.admin.edit', ['id' => $id]);
        } 

        return Redirect::route('company.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Company::find($id)->delete();

        return Redirect::back()->with([
            'companies' => Company::latest()->get(),
        ]);
    }
}
