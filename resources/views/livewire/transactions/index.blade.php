<div>
    <div class="bg-white border-b border-[#E4E0D3]">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-[#1C1D18] leading-tight">
                Transactions
            </h2>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            @if (session()->has('message'))
                <div class="bg-[#E7F0EA] text-[#2A5540] p-3 rounded-md">
                    {{ session('message') }}
                </div>
            @endif


            <div class="bg-white border border-[#E4E0D3] rounded-lg p-4">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-2">
                        <select wire:model.live="filterType" class="border border-[#D3CDBB] rounded-md px-3 py-2 text-sm text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                            <option value="">All Types</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>


                        <select wire:model.live="filterCategory" class="border border-[#D3CDBB] rounded-md px-3 py-2 text-sm text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>


                        <input type="date" wire:model.live="filterDateFrom" class="border border-[#D3CDBB] rounded-md px-3 py-2 text-sm text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">
                        <input type="date" wire:model.live="filterDateTo" class="border border-[#D3CDBB] rounded-md px-3 py-2 text-sm text-[#1C1D18] focus:border-[#17231F] focus:ring-[#17231F]">

                        @if ($dateFilterError)
                            <p class="w-full text-sm text-[#B3261E] mt-1">{{ $dateFilterError }}</p>
                        @endif
                    </div>


                    <a href="{{ route('transactions.create') }}" class="bg-[#17231F] text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-[#2B372F]">
                        + Add Transaction
                    </a>
                </div>
            </div>


            <div class="bg-white border border-[#E4E0D3] rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-[#E4E0D3]">
                    <thead class="bg-[#F6F3EA]">
    <tr>
        <th class="text-left px-6 py-3 text-xs font-medium text-[#6B6A61] uppercase tracking-wider cursor-pointer select-none hover:text-[#1C1D18]" wire:click="sortBy('date')">Date</th>
        <th class="text-left px-6 py-3 text-xs font-medium text-[#6B6A61] uppercase tracking-wider cursor-pointer select-none hover:text-[#1C1D18]" wire:click="sortBy('type')">Type</th>
        <th class="text-left px-6 py-3 text-xs font-medium text-[#6B6A61] uppercase tracking-wider">Category</th>
        <th class="text-left px-6 py-3 text-xs font-medium text-[#6B6A61] uppercase tracking-wider">Description</th>
        <th class="text-right px-6 py-3 text-xs font-medium text-[#6B6A61] uppercase tracking-wider cursor-pointer select-none hover:text-[#1C1D18]" wire:click="sortBy('amount')">Amount</th>
        <th class="text-right px-6 py-3 text-xs font-medium text-[#6B6A61] uppercase tracking-wider">Actions</th>
    </tr>
</thead>
                    <tbody class="divide-y divide-[#E4E0D3]">
                        @forelse ($transactions as $transaction)
                            <tr wire:key="transaction-{{ $transaction->id }}">
                                <td class="px-6 py-4 text-sm text-[#6B6A61]">{{ $transaction->date }}</td>
                                <td class="px-6 py-4">
                                    @if ($transaction->type === 'income')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#E7F0EA] text-[#2A5540]">
                                            Income
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#F4E7E2] text-[#79311F]">
                                            Expense
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-[#1C1D18]">{{ $transaction->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-[#1C1D18]">{{ $transaction->description }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium {{ $transaction->type === 'income' ? 'text-[#2A5540]' : 'text-[#79311F]' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-[#2C4A63] hover:underline">Edit</a>
                                    <button wire:click="delete({{ $transaction->id }})" wire:confirm="Delete this transaction?" class="ml-4 text-red-600 hover:underline">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-[#6B6A61]">No transactions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>