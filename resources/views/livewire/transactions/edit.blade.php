<div>
    <h1 class="text-xl font-bold mb-4">Edit Transaction</h1>

    <form wire:submit="update">
        <div class="mb-4">
            <label class="block font-semibold mb-1">Amount</label>
            <input type="number" step="0.01" wire:model="amount" class="border rounded w-full p-2">
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Type</label>
            <select wire:model="type" class="border rounded w-full p-2">
                <option value="expense">Expense</option>
                <option value="income">Income</option>
            </select>
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Date</label>
            <input type="date" wire:model="date" class="border rounded w-full p-2">
            @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Category</label>
            <select wire:model="category_id" class="border rounded w-full p-2">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Description</label>
            <input type="text" wire:model="description" class="border rounded w-full p-2">
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
    </form>
</div>