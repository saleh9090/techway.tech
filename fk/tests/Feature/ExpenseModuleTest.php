<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_expense_can_be_created_and_redirects_to_index(): void
    {
        $response = $this->post(route('expenses.store'), [
            'date' => '2026-06-10',
            'expense' => 'Flour purchase',
            'amount' => '12.50',
            'details' => 'Kitchen stock',
        ]);

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseHas('expenses', [
            'expense' => 'Flour purchase',
            'amount' => '12.50',
            'details' => 'Kitchen stock',
        ]);
    }

    public function test_expense_can_be_updated_and_redirects_to_index(): void
    {
        $expense = Expense::create([
            'date' => '2026-06-10',
            'expense' => 'Flour purchase',
            'amount' => '12.50',
            'details' => 'Kitchen stock',
        ]);

        $response = $this->put(route('expenses.update', $expense), [
            'date' => '2026-06-11',
            'expense' => 'Oil purchase',
            'amount' => '9.75',
            'details' => 'Updated details',
        ]);

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'expense' => 'Oil purchase',
            'amount' => '9.75',
        ]);
    }

    public function test_expenses_index_is_paginated(): void
    {
        foreach (range(1, 12) as $index) {
            Expense::create([
                'date' => '2026-06-10',
                'expense' => "Expense {$index}",
                'amount' => '1.00',
                'details' => null,
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
                'expense' => "Expense {$index}",
                'amount' => '1.00',
                'details' => null,
            ]);
        }

        $response = $this->get(route('expenses.index', ['per_page' => 20]));

        $response->assertOk();
        $response->assertSee('Showing 1 to 12 of 12');
    }

    public function test_expenses_index_can_be_searched(): void
    {
        Expense::create([
            'date' => '2026-06-10',
            'expense' => 'Flour purchase',
            'amount' => '12.50',
            'details' => null,
        ]);

        Expense::create([
            'date' => '2026-06-10',
            'expense' => 'Oil purchase',
            'amount' => '8.00',
            'details' => null,
        ]);

        $response = $this->get(route('expenses.index', ['search' => 'Flour']));

        $response->assertOk();
        $response->assertSee('Flour purchase');
        $response->assertDontSee('Oil purchase');
    }

    public function test_expenses_index_can_be_filtered_by_date_range(): void
    {
        Expense::create([
            'date' => '2026-06-01',
            'expense' => 'Old expense',
            'amount' => '10.00',
            'details' => null,
        ]);

        Expense::create([
            'date' => '2026-06-10',
            'expense' => 'Current expense',
            'amount' => '20.00',
            'details' => null,
        ]);

        Expense::create([
            'date' => '2026-06-20',
            'expense' => 'Future expense',
            'amount' => '30.00',
            'details' => null,
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
