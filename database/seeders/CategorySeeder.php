<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Give every existing user a sensible starter set of categories,
     * so the app has realistic sample data to demo.
     */
    public function run(): void
    {
        $income  = ['Salary', 'Freelance', 'Interest'];
        $expense = ['Groceries', 'Rent', 'Utilities', 'Transport', 'Dining Out'];

        User::all()->each(function (User $user) use ($income, $expense) {
            foreach ($income as $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name'    => $name,
                    'type'    => 'income',
                ]);
            }

            foreach ($expense as $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name'    => $name,
                    'type'    => 'expense',
                ]);
            }
        });
    }
}