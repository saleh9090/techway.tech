@extends('layouts.app', ['title' => 'Add Expense | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Add Expense</h1>
      <p class="page-subtitle">After saving, you will return to the expenses index.</p>
    </div>
  </header>

  @include('expenses.form', [
      'expense' => $expense,
      'action' => route('expenses.store'),
      'method' => 'POST',
      'button' => 'Save Expense',
  ])
@endsection
