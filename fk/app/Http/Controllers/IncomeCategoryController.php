<?php

namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomeCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $perPage = $this->perPage($request);

        return view('income-categories.index', [
            'categories' => IncomeCategory::query()
                ->withCount('items')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('id')
                ->paginate($perPage)
                ->withQueryString(),
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('income-categories.create', [
            'category' => new IncomeCategory(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        IncomeCategory::create($this->validatedData($request));

        return redirect()
            ->route('income-categories.index')
            ->with('status', 'Income category added.');
    }

    public function edit(IncomeCategory $incomeCategory): View
    {
        return view('income-categories.edit', [
            'category' => $incomeCategory,
        ]);
    }

    public function update(Request $request, IncomeCategory $incomeCategory): RedirectResponse
    {
        $incomeCategory->update($this->validatedData($request));

        return redirect()
            ->route('income-categories.index')
            ->with('status', 'Income category updated.');
    }

    public function destroy(IncomeCategory $incomeCategory): RedirectResponse
    {
        $incomeCategory->delete();

        return redirect()
            ->route('income-categories.index')
            ->with('status', 'Income category deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    private function perPage(Request $request): int
    {
        $perPage = (int) $request->query('per_page', 10);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;
    }
}
