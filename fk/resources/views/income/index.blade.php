@extends('layouts.app', ['title' => 'Income | Fateer Wa Khameer Accounting'])

@section('content')
  <header class="page-header">
    <div>
      <h1 class="page-title">Income</h1>
      <p class="page-subtitle">Record daily income transactions.</p>
    </div>
    <a class="button" href="{{ route('income.create') }}">Add Income</a>
  </header>

  <section class="table-panel">
    <div class="table-toolbar">
      <strong>Income List</strong>
      @include('partials.search-form', [
          'id' => 'income',
          'search' => $search,
          'placeholder' => 'Search income',
          'perPage' => $perPage,
          'showDateFilters' => true,
          'dateFrom' => $dateFrom,
          'dateTo' => $dateTo,
      ])
    </div>

    @if ($income->isEmpty())
      <div class="empty-state">No income added yet.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Income Category</th>
            <th>Income</th>
            <th>Amount</th>
            <th>Note</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($income as $entry)
            <tr>
              <td data-label="ID">{{ $entry->id }}</td>
              <td data-label="Date">{{ $entry->date->format('Y-m-d') }}</td>
              <td data-label="Income Category">{{ $entry->category?->name }}</td>
              <td data-label="Income">{{ $entry->item?->name }}</td>
              <td data-label="Amount">{{ number_format((float) $entry->amount, 2) }}</td>
              <td data-label="Note">{{ $entry->note ?: '-' }}</td>
              <td data-label="Actions">
                <div class="actions">
                  <a class="button button-secondary" href="{{ route('income.edit', $entry) }}">Edit</a>
                  <form method="POST" action="{{ route('income.destroy', $entry) }}">
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
        'paginator' => $income,
    ])
  </section>
@endsection
