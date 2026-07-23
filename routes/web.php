<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    });

    // Agent routes
    Route::middleware(['role:agent|admin'])->group(function () {
        Route::get('/agent', \App\Livewire\Agent\TicketList::class)->name('agent.dashboard');
    });

    // Customer / General routes
    Route::get('/tickets', \App\Livewire\Customer\TicketList::class)->name('tickets.index');
    Route::get('/tickets/create', \App\Livewire\Customer\CreateTicket::class)->name('tickets.create');
    Route::get('/tickets/{ticket}', \App\Livewire\Customer\TicketDetail::class)->name('tickets.show');
});

require __DIR__.'/auth.php';
