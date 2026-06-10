<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        return view('expense-categories.index', [
            'categories' => ExpenseCategory::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('id')
                ->paginate(10)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('expense-categories.create', [
            'category' => new ExpenseCategory(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ExpenseCategory::create($this->validatedData($request));

        return redirect()
            ->route('expense-categories.index')
            ->with('status', 'Category added.');
    }

    public function edit(ExpenseCategory $expenseCategory): View
    {
        return view('expense-categories.edit', [
            'category' => $expenseCategory,
        ]);
    }

    public function update(Request $request, ExpenseCategory $expenseCategory): RedirectResponse
    {
        $expenseCategory->update($this->validatedData($request));

        return redirect()
            ->route('expense-categories.index')
            ->with('status', 'Category updated.');
    }

    public function destroy(ExpenseCategory $expenseCategory): RedirectResponse
    {
        $expenseCategory->delete();

        return redirect()
            ->route('expense-categories.index')
            ->with('status', 'Category deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
    }
}
