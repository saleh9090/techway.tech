@extends('layouts.app', ['title' => 'Edit Expense Category | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Edit Expense Category</h1>
      <p class="page-subtitle">After saving, you will return to the categories index.</p>
    </div>
  </header>

  @include('expense-categories.form', [
      'category' => $category,
      'action' => route('expense-categories.update', $category),
      'method' => 'PUT',
      'button' => 'Update Category',
  ])
@endsection
