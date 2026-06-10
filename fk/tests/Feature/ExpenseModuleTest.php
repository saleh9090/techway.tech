<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseModuleTest extends TestCase
{
    use RefreshDatabase;

    private function createExpenseItem(string $categoryName = 'Food Ingredients | المواد الغذائية', string $itemName = 'Flour'): ExpenseItem
    {
        $category = ExpenseCategory::create([
            'name' => $categoryName,
        ]);

        return ExpenseItem::create([
            'expense_category_id' => $category->id,
            'name' => $itemName,
        ]);
    }

    public function test_expense_can_be_created_and_redirects_to_index(): void
    {
        $item = $this->createExpenseItem();

        $response = $this->post(route('expenses.store'), [
            'date' => '2026-06-10',
            'expense_category_id' => $item->expense_category_id,
            'expense_item_id' => $item->id,
            'amount' => '12.50',
            'note' => 'Paid by cash',
        ]);

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseHas('expenses', [
            'expense_category_id' => $item->expense_category_id,
            'expense_item_id' => $item->id,
            'amount' => '12.50',
            'note' => 'Paid by cash',
        ]);
    }

    public function test_expense_can_be_updated_and_redirects_to_index(): void
    {
        $oldItem = $this->createExpenseItem('Food Ingredients | المواد الغذائية', 'Flour');
        $newItem = $this->createExpenseItem('Packaging Materials | مواد التعبئة والتغليف', 'Paper bags');

        $expense = Expense::create([
            'date' => '2026-06-10',
            'expense_category_id' => $oldItem->expense_category_id,
            'expense_item_id' => $oldItem->id,
            'amount' => '12.50',
            'note' => null,
        ]);

        $response = $this->put(route('expenses.update', $expense), [
            'date' => '2026-06-11',
            'expense_category_id' => $newItem->expense_category_id,
            'expense_item_id' => $newItem->id,
            'amount' => '9.75',
            'note' => 'Updated note',
        ]);

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'expense_category_id' => $newItem->expense_category_id,
            'expense_item_id' => $newItem->id,
            'amount' => '9.75',
            'note' => 'Updated note',
        ]);
    }

    public function test_expenses_index_is_paginated(): void
    {
        foreach (range(1, 12) as $index) {
            Expense::create([
                'date' => '2026-06-10',
                'amount' => '1.00',
            ]);
        }

        $response = $this->get(route('expenses.index', ['page' => 2]));

        $response->assertOk();
        $response->assertSee('Showing 11 to 12 of 12');
    }

    public function test_expenses_index_respects_per_page_option(): void
    {
        foreach (range(1, 12) as $index) {
            Expense::create([
                'date' => '2026-06-10',
                'amount' => '1.00',
            ]);
        }

        $response = $this->get(route('expenses.index', ['per_page' => 20]));

        $response->assertOk();
        $response->assertSee('Showing 1 to 12 of 12');
    }

    public function test_expenses_index_can_be_searched(): void
    {
        $flour = $this->createExpenseItem('Food Ingredients | المواد الغذائية', 'Flour');
        $oil = $this->createExpenseItem('Food Ingredients | المواد الغذائية', 'Oil');

        Expense::create([
            'date' => '2026-06-10',
            'expense_category_id' => $flour->expense_category_id,
            'expense_item_id' => $flour->id,
            'amount' => '12.50',
            'note' => null,
        ]);

        Expense::create([
            'date' => '2026-06-10',
            'expense_category_id' => $oil->expense_category_id,
            'expense_item_id' => $oil->id,
            'amount' => '8.00',
            'note' => null,
        ]);

        $response = $this->get(route('expenses.index', ['search' => 'Flour']));

        $response->assertOk();
        $response->assertSee('Flour');
        $response->assertDontSee('Oil');
    }

    public function test_expenses_index_can_be_filtered_by_date_range(): void
    {
        Expense::create([
            'date' => '2026-06-01',
            'amount' => '10.00',
            'note' => 'Old expense',
        ]);

        Expense::create([
            'date' => '2026-06-10',
            'amount' => '20.00',
            'note' => 'Current expense',
        ]);

        Expense::create([
            'date' => '2026-06-20',
            'amount' => '30.00',
            'note' => 'Future expense',
        ]);

        $response = $this->get(route('expenses.index', [
            'date_from' => '2026-06-05',
            'date_to' => '2026-06-15',
        ]));

        $response->assertOk();
        $response->assertSee('Current expense');
        $response->assertDontSee('Old expense');
        $response->assertDontSee('Future expense');
    }

    public function test_expense_requires_sub_expense_from_selected_category(): void
    {
        $selectedItem = $this->createExpenseItem('Food Ingredients | المواد الغذائية', 'Flour');
        $otherItem = $this->createExpenseItem('Packaging Materials | مواد التعبئة والتغليف', 'Paper bags');

        $response = $this->post(route('expenses.store'), [
            'date' => '2026-06-10',
            'expense_category_id' => $selectedItem->expense_category_id,
            'expense_item_id' => $otherItem->id,
            'amount' => '12.50',
            'note' => null,
        ]);

        $response->assertSessionHasErrors('expense_item_id');
    }

    public function test_expense_items_crud_redirects_to_index(): void
    {
        $category = ExpenseCategory::create([
            'name' => 'Food Ingredients | المواد الغذائية',
        ]);

        $response = $this->post(route('expense-items.store'), [
            'expense_category_id' => $category->id,
            'name' => 'Flour',
        ]);

        $response->assertRedirect(route('expense-items.index'));

        $item = ExpenseItem::firstOrFail();

        $this->assertDatabaseHas('expense_items', [
            'expense_category_id' => $category->id,
            'name' => 'Flour',
        ]);

        $response = $this->put(route('expense-items.update', $item), [
            'expense_category_id' => $category->id,
            'name' => 'Premium flour',
        ]);

        $response->assertRedirect(route('expense-items.index'));

        $this->assertDatabaseHas('expense_items', [
            'id' => $item->id,
            'name' => 'Premium flour',
        ]);
    }

    public function test_expense_items_index_can_be_searched_by_category(): void
    {
        $this->createExpenseItem('Food Ingredients | المواد الغذائية', 'Flour');
        $this->createExpenseItem('Packaging Materials | مواد التعبئة والتغليف', 'Paper bags');

        $response = $this->get(route('expense-items.index', ['search' => 'Packaging']));

        $response->assertOk();
        $response->assertSee('Paper bags');
        $response->assertDontSee('Flour');
    }

    public function test_expense_category_can_be_created_and_redirects_to_index(): void
    {
        $response = $this->post(route('expense-categories.store'), [
            'name' => 'Kitchen Supplies',
        ]);

        $response->assertRedirect(route('expense-categories.index'));

        $this->assertDatabaseHas('expense_categories', [
            'name' => 'Kitchen Supplies',
        ]);
    }

    public function test_expense_category_can_be_updated_and_redirects_to_index(): void
    {
        $category = ExpenseCategory::create([
            'name' => 'Kitchen Supplies',
        ]);

        $response = $this->put(route('expense-categories.update', $category), [
            'name' => 'Packaging',
        ]);

        $response->assertRedirect(route('expense-categories.index'));

        $this->assertDatabaseHas('expense_categories', [
            'id' => $category->id,
            'name' => 'Packaging',
        ]);
    }

    public function test_expense_categories_index_is_paginated(): void
    {
        foreach (range(1, 12) as $index) {
            ExpenseCategory::create([
                'name' => "Category {$index}",
            ]);
        }

        $response = $this->get(route('expense-categories.index', ['page' => 2]));

        $response->assertOk();
        $response->assertSee('Showing 11 to 12 of 12');
    }

    public function test_expense_categories_index_respects_per_page_option(): void
    {
        foreach (range(1, 12) as $index) {
            ExpenseCategory::create([
                'name' => "Category {$index}",
            ]);
        }

        $response = $this->get(route('expense-categories.index', ['per_page' => 20]));

        $response->assertOk();
        $response->assertSee('Showing 1 to 12 of 12');
    }

    public function test_expense_categories_index_can_be_searched(): void
    {
        ExpenseCategory::create([
            'name' => 'Food Ingredients | المواد الغذائية',
        ]);

        ExpenseCategory::create([
            'name' => 'Packaging Materials | مواد التعبئة والتغليف',
        ]);

        $response = $this->get(route('expense-categories.index', ['search' => 'Packaging']));

        $response->assertOk();
        $response->assertSee('Packaging Materials');
        $response->assertDontSee('Food Ingredients');
    }
}
