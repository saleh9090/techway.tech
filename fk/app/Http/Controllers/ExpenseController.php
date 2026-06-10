<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $perPage = $this->perPage($request);

        return view('expenses.index', [
            'expenses' => Expense::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('expense', 'like', "%{$search}%")
                            ->orWhere('date', 'like', "%{$search}%")
                            ->orWhere('amount', 'like', "%{$search}%")
                            ->orWhere('details', 'like', "%{$search}%");
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
        return view('expenses.create', [
            'expense' => new Expense([
                'date' => now()->toDateString(),
                'amount' => '0.00',
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Expense::create($this->validatedData($request));

        return redirect()
            ->route('expenses.index')
            ->with('status', 'Expense added.');
    }

    public function edit(Expense $expense): View
    {
        return view('expenses.edit', [
            'expense' => $expense,
        ]);
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $expense->update($this->validatedData($request));

        return redirect()
            ->route('expenses.index')
            ->with('status', 'Expense updated.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('status', 'Expense deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'date' => ['required', 'date'],
            'expense' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'details' => ['nullable', 'string'],
        ]);
    }

    private function perPage(Request $request): int
    {
        $perPage = (int) $request->query('per_page', 10);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;
    }
}
