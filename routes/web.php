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

require __DIR__.'/auth.php';