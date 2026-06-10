@extends('layouts.app', ['title' => 'Edit Sub Income | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Edit Sub Income</h1>
      <p class="page-subtitle">After saving, you will return to the sub income index.</p>
    </div>
  </header>

  @include('income-items.form', [
      'item' => $item,
      'categories' => $categories,
      'action' => route('income-items.update', $item),
      'method' => 'PUT',
      'button' => 'Update Sub Income',
  ])
@endsection
