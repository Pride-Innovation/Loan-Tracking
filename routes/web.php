<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::get('/leads', function () {
        return Inertia::render('LoanLeads/Index');
    })->name('leads');
    
    Route::get('/leads/create', function () {
        return Inertia::render('LoanLeads/Create');
    })->name('leads.create');

    Route::get('/products', function () {
        return Inertia::render('Products/Index');
    })->name('products');

    Route::get('/settings', function () {
        return Inertia::render('Settings/Index');
    })->name('settings');
});
