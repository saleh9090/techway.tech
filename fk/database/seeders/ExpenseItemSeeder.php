<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\ExpenseItem;
use Illuminate\Database\Seeder;

class ExpenseItemSeeder extends Seeder
{
    public function run(): void
    {
        $itemsByCategory = [
            'Food Ingredients | المواد الغذائية' => [
                'Meat | اللحوم',
                'Chicken | الدجاج',
                'Cheese | الأجبان',
                'Vegetables | الخضروات',
                'Spices & Seasonings | البهارات والتوابل',
                'Flour & Dough Ingredients | الطحين ومكونات العجين',
                'Oil & Ghee | الزيوت والسمن',
                'Dairy Products | منتجات الألبان',
                'Eggs | البيض',
            ],
            'Beverages | المشروبات' => [
                'Tea & Karak Ingredients | الشاي ومكونات الكرك',
                'Water | المياه',
                'Soft Drinks | المشروبات الغازية',
                'Juices | العصائر',
            ],
            'Packaging Materials | مواد التعبئة والتغليف' => [
                'Boxes | العلب والصناديق',
                'Bags | الأكياس',
                'Stickers & Labels | الملصقات',
                'Napkins & Tissues | المناديل',
            ],
            'Salaries & Wages | الرواتب والأجور' => [
                'Employee Salaries | رواتب الموظفين',
                'Overtime | العمل الإضافي',
                'Staff Benefits | مزايا الموظفين',
            ],
            'Rent & Accommodation | الإيجارات والسكن' => [
                'Shop Rent | إيجار المحل',
                'Staff Accommodation | سكن الموظفين',
            ],
            'Utilities | الخدمات' => [
                'Electricity | الكهرباء',
                'Water Utility | المياه',
                'Internet | الإنترنت',
                'Telephone | الهاتف',
            ],
            'Equipment & Maintenance | المعدات والصيانة' => [
                'Kitchen Equipment | معدات المطبخ',
                'Oven Maintenance | صيانة الفرن',
                'Air Conditioning | التكييف',
                'General Maintenance | الصيانة العامة',
            ],
            'Cleaning Supplies | مواد التنظيف' => [
                'Cleaning Chemicals | مواد التنظيف',
                'Cleaning Tools | أدوات التنظيف',
            ],
            'Transportation & Delivery | النقل والتوصيل' => [
                'Fuel | الوقود',
                'Delivery Expenses | مصاريف التوصيل',
                'Vehicle Maintenance | صيانة المركبات',
            ],
            'Marketing & Advertising | التسويق والإعلانات' => [
                'Social Media Ads | إعلانات التواصل الاجتماعي',
                'Printing Materials | المطبوعات',
                'Signboards & Branding | اللوحات والعلامات التجارية',
            ],
            'Office Expenses | المصروفات المكتبية' => [
                'Stationery | القرطاسية',
                'Software & Subscriptions | البرامج والاشتراكات',
            ],
            'Government Fees | الرسوم الحكومية' => [
                'Licenses & Permits | التراخيص والتصاريح',
                'Municipality Fees | رسوم البلدية',
            ],
            'Professional Services | الخدمات المهنية' => [
                'Accounting Services | خدمات المحاسبة',
                'Legal Services | الخدمات القانونية',
                'Consultancy Services | الخدمات الاستشارية',
            ],
            'Staff Welfare | رفاهية الموظفين' => [
                'Meals & Refreshments | الوجبات والضيافة',
                'Uniforms | الزي الموحد',
            ],
            'Miscellaneous Expenses | مصروفات أخرى' => [
                'Other Expenses | مصروفات متنوعة',
            ],
        ];

        foreach ($itemsByCategory as $categoryName => $items) {
            $category = ExpenseCategory::firstOrCreate([
                'name' => $categoryName,
            ]);

            foreach ($items as $item) {
                ExpenseItem::firstOrCreate([
                    'expense_category_id' => $category->id,
                    'name' => $item,
                ]);
            }
        }
    }
}
