<?php

namespace App\Livewire\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;

class Create extends Component
{
    public $amount;
    public $type = 'expense';
    public $date;
    public $description;
    public $category_id;

    public function save()
    {
        $validated = $this->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Transaction::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Transaction added successfully.');

        return redirect()->route('transactions.index');
    }

    public function render()
    {
        return view('livewire.transactions.create', [
            'categories' => Category::where('user_id', auth()->id())->get(),
        ])->layout('layouts.app');
    }
}