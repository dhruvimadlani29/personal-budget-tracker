<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Categories page. The name MUST be "categories.index" so the nav bar link
// (which checks Route::has('categories.index')) appears automatically.
Route::view('categories', 'categories.index')
    ->middleware(['auth'])
    ->name('categories.index');

require __DIR__.'/auth.php';