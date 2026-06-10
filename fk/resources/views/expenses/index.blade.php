@extends('layouts.app', ['title' => 'Expenses | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Expenses</h1>
      <p class="page-subtitle">Record daily expense transactions.</p>
    </div>
    <a class="button" href="{{ route('expenses.create') }}">Add Expense</a>
  </header>

  <section class="table-panel">
    <div class="table-toolbar">
      <strong>Expenses List</strong>
      @include('partials.search-form', [
          'search' => $search,
          'placeholder' => 'Search expenses',
      ])
    </div>

    @if ($expenses->isEmpty())
      <div class="empty-state">No expenses added yet.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Expense</th>
            <th>Amount</th>
            <th>Details</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($expenses as $expense)
            <tr>
              <td>{{ $expense->id }}</td>
              <td>{{ $expense->date->format('Y-m-d') }}</td>
              <td>{{ $expense->expense }}</td>
              <td>{{ number_format((float) $expense->amount, 2) }}</td>
              <td>{{ $expense->details }}</td>
              <td>
                <div class="actions">
                  <a class="button button-secondary" href="{{ route('expenses.edit', $expense) }}">Edit</a>
                  <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
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
        'paginator' => $expenses,
    ])
  </section>
@endsection
