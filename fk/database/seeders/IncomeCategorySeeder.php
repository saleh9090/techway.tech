<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Sales',
            'Other',
        ];

        foreach ($categories as $category) {
            IncomeCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        IncomeCategory::query()
            ->whereNotIn('name', $categories)
            ->whereDoesntHave('income')
            ->whereDoesntHave('items')
            ->delete();
    }
}
