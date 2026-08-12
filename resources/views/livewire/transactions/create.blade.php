<div>
    <div class="bg-white border-b border-[#E4E0D3]">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-[#1C1D18] leading-tight">
                Add Transaction
            </h2>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#E4E0D3] rounded-lg p-6">


                @if (session()->has('message'))
                    <div class="bg-[#E7F0EA] text-[#2A5540] p-3 rounded-md mb-4">
                        {{ session('message') }}
                    </div>
                @endif


                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#6B6A61] mb-1">Amount</label>
                        <input type="number" step="0.01" wire:model="amount" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2 text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]" placeholder="0.00">
                        @error('amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-[#6B6A61] mb-1">Type</label>
                        <select wire:model="type" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2 text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>
                        </select>
                        @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-[#6B6A61] mb-1">Date</label>
                        <input type="date" wire:model="date" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2 text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                        @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-[#6B6A61] mb-1">Category</label>
                        <select wire:model="category_id" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2 text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-[#6B6A61] mb-1">Description</label>
                        <input type="text" wire:model="description" class="w-full border border-[#D3CDBB] rounded-md px-3 py-2 text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div class="flex items-center gap-3">
                        <button type="submit" class="flex-1 bg-[#17231F] text-white rounded-md py-2 font-medium hover:bg-[#2B372F]">
                            Save Transaction
                        </button>
                        <a href="{{ route('transactions.index') }}" wire:navigate class="px-4 py-2 border border-[#D3CDBB] rounded-md text-[#6B6A61] text-center">
                            Cancel
                        </a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
