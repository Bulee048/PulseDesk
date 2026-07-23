<?php

use Illuminate\Support\Facades\Route;

// Marketing Site
Route::view('/', 'welcome');
Route::get('/signup', \App\Livewire\Public\Signup::class)->name('signup');

// Super Admin / System Routes
Route::domain('admin.' . env('APP_DOMAIN', 'localhost'))->group(function () {
    Route::middleware(['auth', 'role:super_admin'])->group(function () {
        Route::get('/admin', \App\Livewire\Admin\Dashboard::class)->name('super.dashboard');
    });

    Route::get('/impersonate/leave', [\App\Http\Controllers\ImpersonationController::class, 'leave'])->name('impersonate.leave');
    
    // Allow login on admin subdomain
    require __DIR__.'/auth.php';
});

// Tenant Routes
Route::domain('{tenant}.' . env('APP_DOMAIN', 'localhost'))->middleware(['tenant'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    Route::middleware(['auth'])->group(function () {
        Route::get('/onboarding', \App\Livewire\Tenant\Onboarding::class)->name('onboarding');

        // Org Admin routes
        Route::middleware(['role:org_admin'])->group(function () {
            Route::get('/billing', \App\Livewire\Tenant\Billing::class)->name('billing');
        });

        // Admin Routes
        Route::middleware(['role:org_admin|agent'])->group(function () {
            Route::view('/admin/dashboard', 'dashboard')->name('admin.dashboard');
            Route::get('/admin/knowledge-base', \App\Livewire\Tenant\KnowledgeBase\AdminManager::class)->name('kb.admin');
        });

        // Agent routes
        Route::middleware(['role:agent|org_admin'])->group(function () {
            Route::get('/agent', \App\Livewire\Agent\TicketList::class)->name('agent.dashboard');
        });

        // Customer / General routes
        Route::get('/tickets', \App\Livewire\Customer\TicketList::class)->name('tickets.index');
        Route::get('/tickets/create', \App\Livewire\Customer\CreateTicket::class)->name('tickets.create');
        Route::get('/tickets/{ticket}', \App\Livewire\Customer\TicketDetail::class)->name('tickets.show');
        
        // Public Knowledge Base (No auth required)
        Route::get('/kb', \App\Livewire\Tenant\KnowledgeBase\PublicIndex::class)->name('kb.index');
        Route::get('/kb/{slug}', \App\Livewire\Tenant\KnowledgeBase\PublicShow::class)->name('kb.show');
    });

    require __DIR__.'/auth.php';
});
