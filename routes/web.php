<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\BudgetLimits;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/budget-limits', BudgetLimits::class)
    ->middleware(['auth'])
    ->name('budget-limits');
// Categories page. The name MUST be "categories.index" so the nav bar link
// (which checks Route::has('categories.index')) appears automatically.
Route::view('categories', 'categories.index')
    ->middleware(['auth'])
    ->name('categories.index');

require __DIR__.'/auth.php';