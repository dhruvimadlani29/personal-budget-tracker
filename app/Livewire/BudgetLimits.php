<?php

namespace App\Livewire;

use App\Models\BudgetLimit;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BudgetLimits extends Component
{
    public $categoryId;
    public $amount;
    public $editingId = null;

    public function save()
    {
        $this->validate([
            'categoryId' => 'required',
            'amount' => 'required|numeric|min:0',
        ], [], [
            'categoryId' => 'category',
        ]);

        if ($this->editingId === null) {
            BudgetLimit::create([
                'user_id' => Auth::id(),
                'category_id' => $this->categoryId,
                'amount' => $this->amount,
            ]);
        } else {
            $limit = BudgetLimit::where('user_id', Auth::id())
                ->findOrFail($this->editingId);
            $limit->update([
                'category_id' => $this->categoryId,
                'amount' => $this->amount,
            ]);
        }

        $this->resetForm();
        session()->flash('message', 'Budget limit saved.');
    }

    public function edit($id)
    {
        $limit = BudgetLimit::where('user_id', Auth::id())->findOrFail($id);
        $this->editingId = $limit->id;
        $this->categoryId = $limit->category_id;
        $this->amount = $limit->amount;
    }

    public function delete($id)
    {
        BudgetLimit::where('user_id', Auth::id())->findOrFail($id)->delete();

        if ($this->editingId == $id) {
            $this->resetForm();
        }

        session()->flash('message', 'Budget limit deleted.');
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->amount = null;
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.budget-limits', [
            'categories' => Category::where('user_id', Auth::id())->get(),
            'limits' => BudgetLimit::where('user_id', Auth::id())
                ->with('category')
                ->get(),
        ])->layout('layouts.app');
    }
}