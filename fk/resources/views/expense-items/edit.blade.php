@extends('layouts.app', ['title' => 'Edit Sub Expense | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Edit Sub Expense</h1>
      <p class="page-subtitle">After saving, you will return to the sub expenses index.</p>
    </div>
  </header>

  @include('expense-items.form', [
      'item' => $item,
      'categories' => $categories,
      'action' => route('expense-items.update', $item),
      'method' => 'PUT',
      'button' => 'Update Sub Expense',
  ])
@endsection
