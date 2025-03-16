<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/company-create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/company-store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/company-edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/company-update/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::post('/company-delete/{id}', [CompanyController::class, 'destroy'])->name('company.delete');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin_dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth:admin'])->name('admin.dashboard');

Route::middleware('auth:admin')->group(function () {
    Route::get('/company-admin', [CompanyController::class, 'index'])->name('company.admin.index');
    Route::get('/company-create-admin', [CompanyController::class, 'create'])->name('company.admin.create');
    Route::post('/company-store-admin', [CompanyController::class, 'store'])->name('company.admin.store');
    Route::get('/company-edit-admin/{id}', [CompanyController::class, 'edit'])->name('company.admin.edit');
    Route::post('/company-update-admin/{id}', [CompanyController::class, 'update'])->name('company.admin.update');
    Route::post('/company-delete-admin/{id}', [CompanyController::class, 'destroy'])->name('company.admin.delete');

    Route::get('/profile-admin', [ProfileController::class, 'edit'])->name('profile.admin.edit');
    Route::patch('/profile-admin', [ProfileController::class, 'update'])->name('profile.admin.update');
    Route::post('/profile-admin', [ProfileController::class, 'destroy'])->name('profile.admin.destroy');
});

require __DIR__.'/auth.php';
