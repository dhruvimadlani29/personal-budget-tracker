<?php

namespace App\Livewire;

use App\Models\BudgetLimit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BudgetLimits extends Component
{
    public $categoryId;
    public $amount;

    public function save()
    {
        $this->validate([
            'categoryId' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        BudgetLimit::create([
            'user_id' => Auth::id(),
            'category_id' => $this->categoryId,
            'amount' => $this->amount,
        ]);

        $this->reset(['categoryId', 'amount']);
        session()->flash('message', 'Budget limit saved.');
    }

   public function render()
{
    return view('livewire.budget-limits')->layout('layouts.app');
}
}