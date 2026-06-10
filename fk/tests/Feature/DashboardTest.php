<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_income_and_expenses_chart_without_summary_cards(): void
    {
        $category = IncomeCategory::create([
            'name' => 'Sales',
        ]);

        $item = IncomeItem::create([
            'income_category_id' => $category->id,
            'name' => 'POS',
        ]);

        Income::create([
            'date' => now()->startOfMonth()->toDateString(),
            'income_category_id' => $category->id,
            'income_item_id' => $item->id,
            'amount' => '100.00',
            'note' => null,
        ]);

        Expense::create([
            'date' => now()->startOfMonth()->toDateString(),
            'amount' => '40.00',
            'note' => null,
        ]);

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Income vs Expenses');
        $response->assertSee('Last 12 months');
        $response->assertSee('100');
        $response->assertSee('40');
        $response->assertDontSee('Latest Expense');
        $response->assertDontSee('Total Income');
    }
}
