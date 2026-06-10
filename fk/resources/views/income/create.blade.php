@extends('layouts.app', ['title' => 'Add Income | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Add Income</h1>
      <p class="page-subtitle">After saving, you will return to the income index.</p>
    </div>
  </header>

  @include('income.form', [
      'income' => $income,
      'action' => route('income.store'),
      'method' => 'POST',
      'button' => 'Save Income',
  ])
@endsection
