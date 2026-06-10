@extends('layouts.app', ['title' => 'Add Expense Category | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Add Expense Category</h1>
      <p class="page-subtitle">After saving, you will return to the categories index.</p>
    </div>
  </header>

  @include('expense-categories.form', [
      'category' => $category,
      'action' => route('expense-categories.store'),
      'method' => 'POST',
      'button' => 'Save Category',
  ])
@endsection
