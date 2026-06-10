<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Food Ingredients | المواد الغذائية',
            'Beverages | المشروبات',
            'Packaging Materials | مواد التعبئة والتغليف',
            'Salaries & Wages | الرواتب والأجور',
            'Rent & Accommodation | الإيجارات والسكن',
            'Utilities | الخدمات',
            'Equipment & Maintenance | المعدات والصيانة',
            'Cleaning Supplies | مواد التنظيف',
            'Transportation & Delivery | النقل والتوصيل',
            'Marketing & Advertising | التسويق والإعلانات',
            'Office Expenses | المصروفات المكتبية',
            'Government Fees | الرسوم الحكومية',
            'Professional Services | الخدمات المهنية',
            'Staff Welfare | رفاهية الموظفين',
            'Miscellaneous Expenses | مصروفات أخرى',
        ];

        ExpenseCategory::query()->delete();
        DB::statement('ALTER TABLE expense_categories AUTO_INCREMENT = 1');

        foreach ($categories as $category) {
            ExpenseCategory::create([
                'name' => $category,
            ]);
        }
    }
}
