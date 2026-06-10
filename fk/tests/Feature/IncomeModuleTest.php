<?php

namespace Tests\Feature;

use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Database\Seeders\IncomeItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomeModuleTest extends TestCase
{
    use RefreshDatabase;

    private function createIncomeItem(string $categoryName = 'Sales Revenue | إيرادات المبيعات', string $itemName = 'Food Sales | مبيعات الأطعمة'): IncomeItem
    {
        $category = IncomeCategory::create([
            'name' => $categoryName,
        ]);

        return IncomeItem::create([
            'income_category_id' => $category->id,
            'name' => $itemName,
        ]);
    }

    public function test_income_can_be_created_and_redirects_to_index(): void
    {
        $item = $this->createIncomeItem();

        $response = $this->post(route('income.store'), [
            'date' => '2026-06-10',
            'income_category_id' => $item->income_category_id,
            'income_item_id' => $item->id,
            'amount' => '42.50',
            'note' => 'Morning sales',
        ]);

        $response->assertRedirect(route('income.index'));

        $this->assertDatabaseHas('incomes', [
            'income_category_id' => $item->income_category_id,
            'income_item_id' => $item->id,
            'amount' => '42.50',
            'note' => 'Morning sales',
        ]);
    }

    public function test_income_can_be_updated_and_redirects_to_index(): void
    {
        $oldItem = $this->createIncomeItem('Sales Revenue | إيرادات المبيعات', 'Food Sales | مبيعات الأطعمة');
        $newItem = $this->createIncomeItem('Delivery Income | إيرادات التوصيل', 'Delivery Fees | رسوم التوصيل');

        $income = Income::create([
            'date' => '2026-06-10',
            'income_category_id' => $oldItem->income_category_id,
            'income_item_id' => $oldItem->id,
            'amount' => '42.50',
            'note' => null,
        ]);

        $response = $this->put(route('income.update', $income), [
            'date' => '2026-06-11',
            'income_category_id' => $newItem->income_category_id,
            'income_item_id' => $newItem->id,
            'amount' => '55.75',
            'note' => 'Updated income note',
        ]);

        $response->assertRedirect(route('income.index'));

        $this->assertDatabaseHas('incomes', [
            'id' => $income->id,
            'income_category_id' => $newItem->income_category_id,
            'income_item_id' => $newItem->id,
            'amount' => '55.75',
            'note' => 'Updated income note',
        ]);
    }

    public function test_income_index_is_paginated_and_searchable(): void
    {
        $food = $this->createIncomeItem('Sales Revenue | إيرادات المبيعات', 'Food Sales | مبيعات الأطعمة');
        $delivery = $this->createIncomeItem('Delivery Income | إيرادات التوصيل', 'Delivery Fees | رسوم التوصيل');

        foreach (range(1, 12) as $index) {
            Income::create([
                'date' => '2026-06-10',
                'income_category_id' => $food->income_category_id,
                'income_item_id' => $food->id,
                'amount' => '1.00',
                'note' => "Income {$index}",
            ]);
        }

        Income::create([
            'date' => '2026-06-10',
            'income_category_id' => $delivery->income_category_id,
            'income_item_id' => $delivery->id,
            'amount' => '20.00',
            'note' => 'Delivery only',
        ]);

        $response = $this->get(route('income.index', ['page' => 2]));

        $response->assertOk();
        $response->assertSee('Showing 11 to 13 of 13');

        $response = $this->get(route('income.index', ['search' => 'Delivery']));

        $response->assertOk();
        $response->assertSee('Delivery Fees');
        $response->assertDontSee('Food Sales');
    }

    public function test_income_index_can_be_filtered_by_date_range(): void
    {
        $item = $this->createIncomeItem();

        Income::create([
            'date' => '2026-06-01',
            'income_category_id' => $item->income_category_id,
            'income_item_id' => $item->id,
            'amount' => '10.00',
            'note' => 'Old income',
        ]);

        Income::create([
            'date' => '2026-06-10',
            'income_category_id' => $item->income_category_id,
            'income_item_id' => $item->id,
            'amount' => '20.00',
            'note' => 'Current income',
        ]);

        Income::create([
            'date' => '2026-06-20',
            'income_category_id' => $item->income_category_id,
            'income_item_id' => $item->id,
            'amount' => '30.00',
            'note' => 'Future income',
        ]);

        $response = $this->get(route('income.index', [
            'date_from' => '2026-06-05',
            'date_to' => '2026-06-15',
        ]));

        $response->assertOk();
        $response->assertSee('Current income');
        $response->assertDontSee('Old income');
        $response->assertDontSee('Future income');
    }

    public function test_income_requires_sub_income_from_selected_category(): void
    {
        $selectedItem = $this->createIncomeItem('Sales Revenue | إيرادات المبيعات', 'Food Sales | مبيعات الأطعمة');
        $otherItem = $this->createIncomeItem('Delivery Income | إيرادات التوصيل', 'Delivery Fees | رسوم التوصيل');

        $response = $this->post(route('income.store'), [
            'date' => '2026-06-10',
            'income_category_id' => $selectedItem->income_category_id,
            'income_item_id' => $otherItem->id,
            'amount' => '12.50',
            'note' => null,
        ]);

        $response->assertSessionHasErrors('income_item_id');
    }

    public function test_income_categories_and_items_crud_redirect_to_index(): void
    {
        $response = $this->post(route('income-categories.store'), [
            'name' => 'Sales Revenue | إيرادات المبيعات',
        ]);

        $response->assertRedirect(route('income-categories.index'));

        $category = IncomeCategory::firstOrFail();

        $response = $this->post(route('income-items.store'), [
            'income_category_id' => $category->id,
            'name' => 'Food Sales | مبيعات الأطعمة',
        ]);

        $response->assertRedirect(route('income-items.index'));

        $item = IncomeItem::firstOrFail();

        $response = $this->put(route('income-items.update', $item), [
            'income_category_id' => $category->id,
            'name' => 'Updated Food Sales | مبيعات الأطعمة',
        ]);

        $response->assertRedirect(route('income-items.index'));

        $this->assertDatabaseHas('income_items', [
            'id' => $item->id,
            'name' => 'Updated Food Sales | مبيعات الأطعمة',
        ]);
    }

    public function test_income_categories_index_shows_sub_income_count(): void
    {
        $category = IncomeCategory::create([
            'name' => 'Sales Revenue | إيرادات المبيعات',
        ]);

        IncomeItem::create([
            'income_category_id' => $category->id,
            'name' => 'Food Sales | مبيعات الأطعمة',
        ]);

        IncomeItem::create([
            'income_category_id' => $category->id,
            'name' => 'Beverage Sales | مبيعات المشروبات',
        ]);

        $response = $this->get(route('income-categories.index'));

        $response->assertOk();
        $response->assertSeeInOrder(['Sales Revenue | إيرادات المبيعات', '2']);
    }

    public function test_default_income_items_are_seeded_under_main_categories(): void
    {
        $this->seed(IncomeItemSeeder::class);

        $sales = IncomeCategory::where('name', 'Sales Revenue | إيرادات المبيعات')->firstOrFail();

        $this->assertDatabaseHas('income_items', [
            'income_category_id' => $sales->id,
            'name' => 'Food Sales | مبيعات الأطعمة',
        ]);

        $this->assertDatabaseHas('income_items', [
            'income_category_id' => $sales->id,
            'name' => 'Beverage Sales | مبيعات المشروبات',
        ]);
    }
}
