@extends('layouts.app', ['title' => 'Add Sub Expense | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Add Sub Expense</h1>
      <p class="page-subtitle">Choose the parent expense category for this item.</p>
    </div>
  </header>

  @include('expense-items.form', [
      'item' => $item,
      'categories' => $categories,
      'action' => route('expense-items.store'),
      'method' => 'POST',
      'button' => 'Save Sub Expense',
  ])
@endsection
