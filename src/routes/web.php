<?php

use App\Http\Controllers\Api\AiController;
use App\Livewire\Chat\Chat;
use App\Livewire\Chat\ChatBot;
use App\Livewire\PostIndex as PostIndex;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::view('/admin', 'pages.auth.login');

Volt::route('admin', 'pages.auth.login')
    ->name('login');

// Volt::route('/logout', 'pages.auth.login')
//         ->name('logout');
Route::get('posts', PostIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('posts.index');

Volt::route('/products', 'product.product-index')
    ->middleware(['auth', 'verified'])
    ->name('products.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/write', [AiController::class, 'index']);

Route::get('/chat', Chat::class)
        ->middleware(['auth', 'verified'])
        ->name('chat.index');
    
require __DIR__ . '/auth.php';
