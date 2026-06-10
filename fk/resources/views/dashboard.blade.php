@extends('layouts.app', ['title' => 'Dashboard | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Dashboard</h1>
      <p class="page-subtitle">Laravel accounting system for Fateer Wa Khameer operations.</p>
    </div>
  </header>

  <section class="metric-grid" aria-label="Expense summary">
    <article class="card">
      <span>Expenses</span>
      <strong>{{ \App\Models\Expense::count() }}</strong>
    </article>
    <article class="card">
      <span>Total Amount</span>
      <strong>{{ number_format(\App\Models\Expense::sum('amount'), 2) }}</strong>
    </article>
    <article class="card">
      <span>Categories</span>
      <strong>{{ \App\Models\ExpenseCategory::count() }}</strong>
    </article>
    <article class="card">
      <span>Sub Expenses</span>
      <strong>{{ \App\Models\ExpenseItem::count() }}</strong>
    </article>
    <article class="card">
      <span>Latest Expense</span>
      @php($latestExpense = \App\Models\Expense::query()->with('item')->latest('date')->latest('id')->first())
      <strong>{{ $latestExpense ? $latestExpense->date->format('Y-m-d').' - '.($latestExpense->item?->name ?? 'Expense') : 'No expenses yet' }}</strong>
    </article>
  </section>
@endsection
