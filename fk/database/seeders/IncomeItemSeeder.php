<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Illuminate\Database\Seeder;

class IncomeItemSeeder extends Seeder
{
    public function run(): void
    {
        $itemsByCategory = [
            'Sales' => [
                'POS',
                'Transfer',
                'Talabat',
                'Cash',
            ],
            'Other' => [],
        ];

        $itemNames = collect($itemsByCategory)->flatten()->all();

        IncomeItem::query()
            ->whereNotIn('name', $itemNames)
            ->whereDoesntHave('income')
            ->delete();

        foreach ($itemsByCategory as $categoryName => $items) {
            $category = IncomeCategory::firstOrCreate([
                'name' => $categoryName,
            ]);

            foreach ($items as $item) {
                IncomeItem::firstOrCreate([
                    'income_category_id' => $category->id,
                    'name' => $item,
                ]);
            }
        }

        IncomeCategory::query()
            ->whereNotIn('name', array_keys($itemsByCategory))
            ->whereDoesntHave('income')
            ->whereDoesntHave('items')
            ->delete();
    }
}
