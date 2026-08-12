<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Transactions\Index as TransactionsIndex;
use App\Livewire\Transactions\Create as TransactionsCreate;
use App\Livewire\Transactions\Edit as TransactionsEdit;
use App\Livewire\BudgetLimits;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/transactions', TransactionsIndex::class)->name('transactions.index');
    Route::get('/transactions/create', TransactionsCreate::class)->name('transactions.create');
    Route::get('/transactions/{id}/edit', TransactionsEdit::class)->name('transactions.edit');
});

Route::get('/budget-limits', BudgetLimits::class)
    ->middleware(['auth'])
    ->name('budget-limits');

// Categories page. The name MUST be "categories.index" so the nav bar link
// (which checks Route::has('categories.index')) appears automatically.
Route::view('categories', 'categories.index')
    ->middleware(['auth'])
    ->name('categories.index');

require __DIR__.'/auth.php';