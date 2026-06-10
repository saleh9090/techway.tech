@extends('layouts.app', ['title' => 'Add Sub Income | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Add Sub Income</h1>
      <p class="page-subtitle">Choose the parent income category for this item.</p>
    </div>
  </header>

  @include('income-items.form', [
      'item' => $item,
      'categories' => $categories,
      'action' => route('income-items.store'),
      'method' => 'POST',
      'button' => 'Save Sub Income',
  ])
@endsection
