<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Sales Revenue | إيرادات المبيعات',
            'Delivery Income | إيرادات التوصيل',
            'Online Sales | مبيعات الإنترنت',
            'Other Income | إيرادات أخرى',
        ];

        foreach ($categories as $category) {
            IncomeCategory::firstOrCreate([
                'name' => $category,
            ]);
        }
    }
}
