<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\ExpenseItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseItemController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $perPage = $this->perPage($request);

        return view('expense-items.index', [
            'items' => ExpenseItem::query()
                ->with('category')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhereHas('category', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                    });
                })
                ->orderBy('expense_category_id')
                ->orderBy('id')
                ->paginate($perPage)
                ->withQueryString(),
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('expense-items.create', [
            'item' => new ExpenseItem(),
            'categories' => ExpenseCategory::query()->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ExpenseItem::create($this->validatedData($request));

        return redirect()
            ->route('expense-items.index')
            ->with('status', 'Sub expense added.');
    }

    public function edit(ExpenseItem $expenseItem): View
    {
        return view('expense-items.edit', [
            'item' => $expenseItem,
            'categories' => ExpenseCategory::query()->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, ExpenseItem $expenseItem): RedirectResponse
    {
        $expenseItem->update($this->validatedData($request));

        return redirect()
            ->route('expense-items.index')
            ->with('status', 'Sub expense updated.');
    }

    public function destroy(ExpenseItem $expenseItem): RedirectResponse
    {
        $expenseItem->delete();

        return redirect()
            ->route('expense-items.index')
            ->with('status', 'Sub expense deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'expense_category_id' => ['required', 'exists:expense_categories,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    private function perPage(Request $request): int
    {
        $perPage = (int) $request->query('per_page', 10);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;
    }
}
