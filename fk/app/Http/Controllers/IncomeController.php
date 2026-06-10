<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IncomeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $perPage = $this->perPage($request);

        return view('income.index', [
            'income' => Income::query()
                ->with(['category', 'item'])
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('date', 'like', "%{$search}%")
                            ->orWhere('amount', 'like', "%{$search}%")
                            ->orWhere('note', 'like', "%{$search}%")
                            ->orWhereHas('category', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('item', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                    });
                })
                ->when($dateFrom, fn ($query) => $query->whereDate('date', '>=', $dateFrom))
                ->when($dateTo, fn ($query) => $query->whereDate('date', '<=', $dateTo))
                ->latest('date')
                ->latest('id')
                ->paginate($perPage)
                ->withQueryString(),
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('income.create', [
            'income' => new Income([
                'date' => now()->toDateString(),
                'amount' => '0.00',
            ]),
            'categories' => IncomeCategory::query()->orderBy('id')->get(),
            'items' => IncomeItem::query()->orderBy('income_category_id')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Income::create($this->validatedData($request));

        return redirect()
            ->route('income.index')
            ->with('status', 'Income added.');
    }

    public function edit(Income $income): View
    {
        return view('income.edit', [
            'income' => $income,
            'categories' => IncomeCategory::query()->orderBy('id')->get(),
            'items' => IncomeItem::query()->orderBy('income_category_id')->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, Income $income): RedirectResponse
    {
        $income->update($this->validatedData($request));

        return redirect()
            ->route('income.index')
            ->with('status', 'Income updated.');
    }

    public function destroy(Income $income): RedirectResponse
    {
        $income->delete();

        return redirect()
            ->route('income.index')
            ->with('status', 'Income deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'date' => ['required', 'date'],
            'income_category_id' => ['required', 'exists:income_categories,id'],
            'income_item_id' => [
                'required',
                Rule::exists('income_items', 'id')
                    ->where(fn ($query) => $query->where('income_category_id', $request->input('income_category_id'))),
            ],
            'amount' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string'],
        ]);
    }

    private function perPage(Request $request): int
    {
        $perPage = (int) $request->query('per_page', 10);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;
    }
}
