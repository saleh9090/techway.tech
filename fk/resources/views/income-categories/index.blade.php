@extends('layouts.app', ['title' => 'Income Categories | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Income Categories</h1>
      <p class="page-subtitle">Manage the names used for income grouping.</p>
    </div>
    <a class="button" href="{{ route('income-categories.create') }}">Add Category</a>
  </header>

  <section class="table-panel">
    <div class="table-toolbar">
      <strong>Income Categories List</strong>
      @include('partials.search-form', [
          'id' => 'income-categories',
          'search' => $search,
          'placeholder' => 'Search income categories',
          'perPage' => $perPage,
      ])
    </div>

    @if ($categories->isEmpty())
      <div class="empty-state">No income categories added yet.</div>
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
                  <a class="button button-secondary" href="{{ route('income-categories.edit', $category) }}">Edit</a>
                  <form method="POST" action="{{ route('income-categories.destroy', $category) }}">
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
