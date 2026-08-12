<div>
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        <div class="flex gap-2">
            <select wire:model.live="filterType" class="border rounded p-2">
                <option value="">All Types</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>

            <select wire:model.live="filterCategory" class="border rounded p-2">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <input type="date" wire:model.live="filterDateFrom" class="border rounded p-2">
            <input type="date" wire:model.live="filterDateTo" class="border rounded p-2">
        </div>

        <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Transaction
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="border-b">
                <th class="text-left p-2 cursor-pointer" wire:click="sortBy('date')">Date</th>
                <th class="text-left p-2 cursor-pointer" wire:click="sortBy('type')">Type</th>
                <th class="text-left p-2">Category</th>
                <th class="text-left p-2">Description</th>
                <th class="text-right p-2 cursor-pointer" wire:click="sortBy('amount')">Amount</th>
                <th class="text-right p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr class="border-b">
                    <td class="p-2">{{ $transaction->date }}</td>
                    <td class="p-2 capitalize">{{ $transaction->type }}</td>
                    <td class="p-2">{{ $transaction->category->name ?? '-' }}</td>
                    <td class="p-2">{{ $transaction->description }}</td>
                    <td class="p-2 text-right">${{ number_format($transaction->amount, 2) }}</td>
                    <td class="p-2 text-right space-x-2">
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-blue-600">Edit</a>
                        <button wire:click="delete({{ $transaction->id }})" wire:confirm="Delete this transaction?" class="text-red-600">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">No transactions yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>