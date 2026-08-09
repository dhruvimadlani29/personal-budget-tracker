<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Category;

class Edit extends Component
{
    public Transaction $transaction;

    public $amount;
    public $type;
    public $date;
    public $description;
    public $category_id;

    public function mount(Transaction $transaction)
    {
        // make sure users can only edit their own transactions
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $this->transaction = $transaction;
        $this->amount = $transaction->amount;
        $this->type = $transaction->type;
        $this->date = $transaction->date;
        $this->description = $transaction->description;
        $this->category_id = $transaction->category_id;
    }

    public function update()
    {
        $validated = $this->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->transaction->update($validated);

        session()->flash('message', 'Transaction updated successfully.');

        return redirect()->route('transactions.index');
    }

    public function render()
    {
        return view('livewire.transactions.edit', [
            'categories' => Category::where('user_id', auth()->id())->get(),
        ]);
    }
}