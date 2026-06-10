@extends('layouts.app', ['title' => 'Expenses Categories | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Expenses Categories</h1>
      <p class="page-subtitle">Manage the names used for expense grouping.</p>
    </div>
    <a class="button" href="{{ route('expense-categories.create') }}">Add Category</a>
  </header>

  <section class="table-panel">
    <div class="table-toolbar">
      <strong>Categories List</strong>
      @include('partials.search-form', [
          'id' => 'categories',
          'search' => $search,
          'placeholder' => 'Search categories',
          'perPage' => $perPage,
      ])
    </div>

    @if ($categories->isEmpty())
      <div class="empty-state">No categories added yet.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Sub</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->name }}</td>
              <td>{{ $category->items_count }}</td>
              <td>
                <div class="actions">
                  <a class="button button-secondary" href="{{ route('expense-categories.edit', $category) }}">Edit</a>
                  <form method="POST" action="{{ route('expense-categories.destroy', $category) }}">
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
        'paginator' => $categories,
    ])
  </section>
@endsection
