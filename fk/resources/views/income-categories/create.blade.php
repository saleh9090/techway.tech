@extends('layouts.app', ['title' => 'Add Income Category | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Add Income Category</h1>
      <p class="page-subtitle">After saving, you will return to the income categories index.</p>
    </div>
  </header>

  @include('income-categories.form', [
      'category' => $category,
      'action' => route('income-categories.store'),
      'method' => 'POST',
      'button' => 'Save Category',
  ])
@endsection
