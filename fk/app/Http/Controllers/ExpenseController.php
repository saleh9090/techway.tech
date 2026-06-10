<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(): View
    {
        return view('expenses.index', [
            'expenses' => Expense::query()
                ->latest('date')
                ->latest('id')
                ->get(),
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
}
