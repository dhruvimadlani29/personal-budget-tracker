<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Category;

class Index extends Component
{
    public $sortBy = 'date';
    public $sortDirection = 'desc';
    public $filterType = '';
    public $filterCategory = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';
    public $dateFilterError = '';

    public function updated($property)
    {
        if (in_array($property, ['filterDateFrom', 'filterDateTo'])) {
            $this->validateDateRange();
        }
    }

    protected function validateDateRange()
    {
        if ($this->filterDateFrom && $this->filterDateTo
            && $this->filterDateFrom > $this->filterDateTo) {
            $this->dateFilterError = 'The "from" date must be before the "to" date.';
        } else {
            $this->dateFilterError = '';
        }
    }

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
        $this->validateDateRange();

        $transactions = Transaction::where('user_id', auth()->id())
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->when($this->filterDateFrom && !$this->dateFilterError, function ($query) {
                $query->whereDate('date', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateTo && !$this->dateFilterError, function ($query) {
                $query->whereDate('date', '<=', $this->filterDateTo);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->with('category')
            ->get();

        $categories = Category::where('user_id', auth()->id())->get();

        return view('livewire.transactions.index', [
            'transactions' => $transactions,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}