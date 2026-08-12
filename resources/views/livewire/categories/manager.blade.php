<?php

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component
{
    // ---- Form state -------------------------------------------------------
    // These public properties are bound to the form inputs with wire:model.
    public string $name = '';
    public string $type = 'expense';

    // When null we are ADDING a new category. When it holds an id we are
    // EDITING the category with that id. The form re-uses the same fields.
    public ?int $editingId = null;

    // ---- Validation rules -------------------------------------------------
    // Kept in one place so add and edit validate identically.
    protected function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:255',
                // Name must be unique *for this user only* (two different users
                // can both have a "Groceries" category). On edit, ignore the row
                // we're currently editing so re-saving it isn't flagged as a dupe.
                Rule::unique('categories')
                    ->where(fn ($query) => $query->where('user_id', auth()->id()))
                    ->ignore($this->editingId),
            ],
            'type' => ['required', Rule::in(['income', 'expense'])],
        ];
    }

    // ---- Read: the current user's categories ------------------------------
    // #[Computed] re-runs on every render, so the list refreshes automatically
    // after any add / edit / delete. It is scoped to the logged-in user, so
    // nobody ever sees another user's categories.
    #[Computed]
    public function categories()
    {
        return Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();
    }

    // ---- Create or Update -------------------------------------------------
    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingId === null) {
            // CREATE: attach the new category to the logged-in user.
            $validated['user_id'] = auth()->id();
            Category::create($validated);
        } else {
            // UPDATE: find the row *scoped to this user* so a user can't edit
            // someone else's category by tampering with the id. findOrFail
            // throws a 404 if the id isn't one of their rows.
            $category = Category::where('user_id', auth()->id())->findOrFail($this->editingId);
            $category->update($validated);
        }

        $this->resetForm();

        // Fires the small "Saved." confirmation next to the button.
        $this->dispatch('category-saved');
    }

    // ---- Load a row into the form for editing -----------------------------
    public function edit(int $id): void
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->type = $category->type;
    }

    // ---- Delete -----------------------------------------------------------
    public function delete(int $id): void
    {
        Category::where('user_id', auth()->id())->findOrFail($id)->delete();

        // If we were editing the row we just deleted, clear the form.
        if ($this->editingId === $id) {
            $this->resetForm();
        }
    }

    // ---- Reset the form back to "add" mode --------------------------------
    public function resetForm(): void
    {
        $this->reset(['name', 'type', 'editingId']);
        $this->type = 'expense';        // sensible default after reset
        $this->resetValidation();
    }
}; ?>

<div>
    {{-- ============ ADD / EDIT FORM ============ --}}
    <div class="bg-white border border-[#E4E0D3] rounded-lg p-6">
        <h2 class="text-lg font-medium text-[#1C1D18]">
            {{ $editingId ? __('Edit category') : __('Add a category') }}
        </h2>
        <p class="mt-1 text-sm text-[#6B6A61]">
            {{ __('Categories group your transactions as either income or expense.') }}
        </p>

        <form wire:submit="save" class="mt-6 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input wire:model="name" id="name" name="name" type="text"
                                  class="mt-1 block w-full" autofocus placeholder="e.g. Groceries" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Type --}}
                <div>
                    <x-input-label for="type" :value="__('Type')" />
                    <select wire:model="type" id="type" name="type"
                            class="mt-1 block w-full border-[#D3CDBB] focus:border-[#17231F] focus:ring-[#17231F] rounded-md shadow-sm">
                        <option value="expense">{{ __('Expense') }}</option>
                        <option value="income">{{ __('Income') }}</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>
                    {{ $editingId ? __('Update category') : __('Add category') }}
                </x-primary-button>

                @if ($editingId)
                    <x-secondary-button type="button" wire:click="resetForm">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                @endif

                <x-action-message class="me-3" on="category-saved">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </div>

    {{-- ============ LISTING ============ --}}
    <div class="bg-white border border-[#E4E0D3] rounded-lg mt-6 overflow-hidden">
        <div class="p-6 border-b border-[#E4E0D3]">
            <h2 class="text-lg font-medium text-[#1C1D18]">{{ __('Your categories') }}</h2>
        </div>

        @if ($this->categories->isEmpty())
            <div class="p-6 text-sm text-[#6B6A61]">
                {{ __('No categories yet. Add your first one above.') }}
            </div>
        @else
            <table class="min-w-full divide-y divide-[#E4E0D3]">
                <thead class="bg-[#F6F3EA]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#6B6A61] uppercase tracking-wider">{{ __('Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#6B6A61] uppercase tracking-wider">{{ __('Type') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[#6B6A61] uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4E0D3]">
                    @foreach ($this->categories as $category)
                        <tr wire:key="category-{{ $category->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#1C1D18]">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($category->type === 'income')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#E7F0EA] text-[#2A5540]">
                                        {{ __('Income') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#F4E7E2] text-[#79311F]">
                                        {{ __('Expense') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $category->id }})"
                                        class="text-[#2C4A63] hover:underline">
                                    {{ __('Edit') }}
                                </button>
                                <button wire:click="delete({{ $category->id }})"
                                        wire:confirm="{{ __('Delete this category? This cannot be undone.') }}"
                                        class="ms-4 text-red-600 hover:text-red-900">
                                    {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>