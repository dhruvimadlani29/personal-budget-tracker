<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white border border-[#E4E0D3] rounded-lg p-6">
        <h2 class="text-lg font-semibold text-[#1C1D18] mb-4">
            {{ $editingId ? 'Edit budget limit' : 'Set a budget limit' }}
        </h2>

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

            <div class="flex items-center gap-3">
                <button type="submit" class="flex-1 bg-[#17231F] text-white rounded-md py-2 font-medium">
                    {{ $editingId ? 'Update limit' : 'Save limit' }}
                </button>
                @if ($editingId)
                    <button type="button" wire:click="resetForm" class="px-4 py-2 border border-[#D3CDBB] rounded-md text-[#6B6A61]">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white border border-[#E4E0D3] rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E4E0D3]">
            <h2 class="text-lg font-semibold text-[#1C1D18]">Your budget limits</h2>
        </div>

        @if ($limits->isEmpty())
            <div class="p-6 text-sm text-[#6B6A61]">
                No budget limits yet. Set your first one above.
            </div>
        @else
            <table class="min-w-full divide-y divide-[#E4E0D3]">
                <thead class="bg-[#F6F3EA]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#6B6A61] uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#6B6A61] uppercase tracking-wider">Monthly limit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[#6B6A61] uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4E0D3]">
                    @foreach ($limits as $limit)
                        <tr wire:key="limit-{{ $limit->id }}">
                            <td class="px-6 py-4 text-sm font-medium text-[#1C1D18]">
                                {{ $limit->category->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#1C1D18]">
                                ${{ number_format($limit->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <button wire:click="edit({{ $limit->id }})" class="text-[#2C4A63] hover:underline">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $limit->id }})"
                                        wire:confirm="Delete this budget limit?"
                                        class="ml-4 text-red-600 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>