@extends('layouts.app', ['title' => 'Sub Expenses | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Sub Expenses</h1>
      <p class="page-subtitle">Manage expense items under each expense category.</p>
    </div>
    <a class="button" href="{{ route('expense-items.create') }}">Add Sub Expense</a>
  </header>

  <section class="table-panel">
    <div class="table-toolbar">
      <strong>Sub Expenses List</strong>
      @include('partials.search-form', [
          'id' => 'items',
          'search' => $search,
          'placeholder' => 'Search sub expenses',
          'perPage' => $perPage,
      ])
    </div>

    @if ($items->isEmpty())
      <div class="empty-state">No sub expenses added yet.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Expense Category</th>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->category?->name }}</td>
              <td>{{ $item->name }}</td>
              <td>
                <div class="actions">
                  <a class="button button-secondary" href="{{ route('expense-items.edit', $item) }}">Edit</a>
                  <form method="POST" action="{{ route('expense-items.destroy', $item) }}">
                    @csrf
                    @method('DELETE')
                    <button class="button button-danger" type="submit">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    @include('partials.pagination', [
        'paginator' => $items,
    ])
  </section>
@endsection
