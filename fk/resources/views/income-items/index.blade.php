@extends('layouts.app', ['title' => 'Sub Income | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Sub Income</h1>
      <p class="page-subtitle">Manage income items under each income category.</p>
    </div>
    <a class="button" href="{{ route('income-items.create') }}">Add Sub Income</a>
  </header>

  <section class="table-panel">
    <div class="table-toolbar">
      <strong>Sub Income List</strong>
      @include('partials.search-form', [
          'id' => 'income-items',
          'search' => $search,
          'placeholder' => 'Search sub income',
          'perPage' => $perPage,
      ])
    </div>

    @if ($items->isEmpty())
      <div class="empty-state">No sub income added yet.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Income Category</th>
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
                  <a class="button button-secondary" href="{{ route('income-items.edit', $item) }}">Edit</a>
                  <form method="POST" action="{{ route('income-items.destroy', $item) }}">
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
