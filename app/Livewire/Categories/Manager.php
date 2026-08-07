<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class Manager extends Component
{
    public $name = '';
    public $type = 'expense';
    public $editingId = null;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:expense,income'],
        ];
    }

    public function save()
    {
        $this->validate();

        Category::updateOrCreate(
            [
                'id' => $this->editingId,
                'user_id' => auth()->id(),
            ],
            [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'type' => $this->type,
            ]
        );

        $this->resetForm();

        $this->dispatch('category-saved');
    }

    public function edit($id)
    {
        $category = Category::where('user_id', auth()->id())
            ->findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->type = $category->type;
    }

    public function delete($id)
    {
        Category::where('user_id', auth()->id())
            ->findOrFail($id)
            ->delete();

        if ($this->editingId == $id) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = 'expense';
        $this->editingId = null;
    }

    public function getCategoriesProperty()
    {
        return Category::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.categories.manager');
    }
}