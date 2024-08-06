<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\PostIndex as PostIndex;

// Route::view('/admin', 'pages.auth.login');

Volt::route('admin', 'pages.auth.login')
        ->name('login');

        
// Volt::route('/logout', 'pages.auth.login')
//         ->name('logout');
Route::get('/posts', PostIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('posts.index');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



require __DIR__.'/auth.php';
