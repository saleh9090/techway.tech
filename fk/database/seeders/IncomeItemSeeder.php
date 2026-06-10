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
            'Sales Revenue | إيرادات المبيعات' => [
                'Food Sales | مبيعات الأطعمة',
                'Beverage Sales | مبيعات المشروبات',
                'Catering Sales | مبيعات الضيافة',
            ],
            'Delivery Income | إيرادات التوصيل' => [
                'Delivery Fees | رسوم التوصيل',
                'Delivery Platform Sales | مبيعات منصات التوصيل',
            ],
            'Online Sales | مبيعات الإنترنت' => [
                'Website Sales | مبيعات الموقع',
                'Social Media Sales | مبيعات وسائل التواصل',
            ],
            'Other Income | إيرادات أخرى' => [
                'Refunds & Rebates | الاستردادات والخصومات',
                'Miscellaneous Income | إيرادات متنوعة',
            ],
        ];

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
    }
}
