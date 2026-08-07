<?php

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Volt\Component;

new class extends Component
{
    // with() runs on every render and hands these values to the Blade below.
    public function with(): array
    {
        $userId = auth()->id();

        $categories    = Category::where('user_id', $userId)->get();
        $incomeCount   = $categories->where('type', 'income')->count();
        $expenseCount  = $categories->where('type', 'expense')->count();

        // The Transactions table is Amal's module. Until it is merged we simply
        // report zeros and a small notice, instead of crashing. Once the table
        // exists these queries run and the numbers appear automatically.
        $hasTransactions = Schema::hasTable('transactions');

        $totalIncome  = 0.0;
        $totalExpense = 0.0;
        $spending     = collect();

        if ($hasTransactions) {
            $totalIncome = (float) DB::table('transactions')
                ->where('user_id', $userId)->where('type', 'income')->sum('amount');

            $totalExpense = (float) DB::table('transactions')
                ->where('user_id', $userId)->where('type', 'expense')->sum('amount');

            // Spending grouped by category (expenses only), biggest first.
            $spending = DB::table('transactions')
                ->join('categories', 'transactions.category_id', '=', 'categories.id')
                ->where('transactions.user_id', $userId)
                ->where('transactions.type', 'expense')
                ->groupBy('categories.id', 'categories.name')
                ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
                ->orderByDesc('total')
                ->get();
        }

        // Largest single-category total, used to size the bar-chart widths.
        $maxSpend = (float) ($spending->max('total') ?? 0);

        return [
            'categoriesCount' => $categories->count(),
            'incomeCount'     => $incomeCount,
            'expenseCount'    => $expenseCount,
            'hasTransactions' => $hasTransactions,
            'totalIncome'     => $totalIncome,
            'totalExpense'    => $totalExpense,
            'balance'         => $totalIncome - $totalExpense,
            'spending'        => $spending,
            'maxSpend'        => $maxSpend,
        ];
    }
}; ?>

<div class="space-y-6">
    {{-- ===== Summary cards ===== --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">{{ __('Total income') }}</p>
            <p class="mt-1 text-2xl font-semibold text-green-600">${{ number_format($totalIncome, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">{{ __('Total expenses') }}</p>
            <p class="mt-1 text-2xl font-semibold text-amber-600">${{ number_format($totalExpense, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">{{ __('Balance') }}</p>
            <p class="mt-1 text-2xl font-semibold {{ $balance >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                ${{ number_format($balance, 2) }}
            </p>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">{{ __('Categories') }}</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $categoriesCount }}</p>
            <p class="mt-1 text-xs text-gray-400">{{ $incomeCount }} {{ __('income') }} · {{ $expenseCount }} {{ __('expense') }}</p>
        </div>
    </div>

    {{-- ===== Spending by category (simple CSS bar chart) ===== --}}
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Spending by category') }}</h3>

        @if (! $hasTransactions)
            <p class="mt-4 text-sm text-gray-500">
                {{ __('Waiting on the Transactions module. Spending totals will appear here once it is merged.') }}
            </p>
        @elseif ($spending->isEmpty())
            <p class="mt-4 text-sm text-gray-500">
                {{ __('No expense transactions yet.') }}
            </p>
        @else
            <div class="mt-4 space-y-4">
                @foreach ($spending as $row)
                    <div>
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>{{ $row->name }}</span>
                            <span class="font-medium">${{ number_format($row->total, 2) }}</span>
                        </div>
                        <div class="mt-1 h-2 w-full rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-[#C99A3A]"
                                 style="width: {{ $maxSpend > 0 ? round(($row->total / $maxSpend) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>