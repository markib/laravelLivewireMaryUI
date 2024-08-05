<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::view('/admin', 'pages.auth.login');

Volt::route('admin', 'pages.auth.login')
        ->name('login');

        
// Volt::route('/logout', 'pages.auth.login')
//         ->name('logout');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



require __DIR__.'/auth.php';
