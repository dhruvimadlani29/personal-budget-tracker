<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Transactions\Index as TransactionsIndex;
use App\Livewire\Transactions\Create as TransactionsCreate;
use App\Livewire\Transactions\Edit as TransactionsEdit;

Route::get('/', function () {
    return view('welcome');
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
    Route::get('/transactions/{transaction}/edit', TransactionsEdit::class)->name('transactions.edit');
});

require __DIR__.'/auth.php';