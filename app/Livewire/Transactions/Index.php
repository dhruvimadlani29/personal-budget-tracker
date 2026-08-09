<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use App\Models\Transaction;

class Index extends Component
{
    public $sortBy = 'date';
    public $sortDirection = 'desc';
    public $filterType = '';

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);
        $transaction->delete();

        session()->flash('message', 'Transaction deleted.');
    }

    public function render()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->with('category')
            ->get();

        return view('livewire.transactions.index', [
            'transactions' => $transactions,
        ])->layout('.layouts.app');
    }
}