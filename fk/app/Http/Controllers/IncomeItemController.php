<?php

namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomeItemController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $perPage = $this->perPage($request);

        return view('income-items.index', [
            'items' => IncomeItem::query()
                ->with('category')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhereHas('category', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                    });
                })
                ->orderBy('income_category_id')
                ->orderBy('id')
                ->paginate($perPage)
                ->withQueryString(),
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('income-items.create', [
            'item' => new IncomeItem(),
            'categories' => IncomeCategory::query()->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        IncomeItem::create($this->validatedData($request));

        return redirect()
            ->route('income-items.index')
            ->with('status', 'Sub income added.');
    }

    public function edit(IncomeItem $incomeItem): View
    {
        return view('income-items.edit', [
            'item' => $incomeItem,
            'categories' => IncomeCategory::query()->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, IncomeItem $incomeItem): RedirectResponse
    {
        $incomeItem->update($this->validatedData($request));

        return redirect()
            ->route('income-items.index')
            ->with('status', 'Sub income updated.');
    }

    public function destroy(IncomeItem $incomeItem): RedirectResponse
    {
        $incomeItem->delete();

        return redirect()
            ->route('income-items.index')
            ->with('status', 'Sub income deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'income_category_id' => ['required', 'exists:income_categories,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    private function perPage(Request $request): int
    {
        $perPage = (int) $request->query('per_page', 10);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;
    }
}
