<div class="max-w-md mx-auto bg-white border border-[#E4E0D3] rounded-lg p-6">
    <h2 class="text-lg font-semibold text-[#1C1D18] mb-4">Set a budget limit</h2>

    @if (session('message'))
        <div class="mb-4 text-sm text-[#2A5540] bg-[#E7F0EA] px-3 py-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-[#6B6A61] mb-1">Category</label>
            <select wire:model="categoryId" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2">
               <option value="">Select a category</option>
@foreach ($categories as $category)
    <option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
            </select>
            @error('categoryId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-[#6B6A61] mb-1">Monthly limit ($)</label>
            <input type="number" step="0.01" wire:model="amount" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2" placeholder="0.00">
            @error('amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-[#17231F] text-white rounded-md py-2 font-medium">
            Save limit
        </button>
    </form>
</div>