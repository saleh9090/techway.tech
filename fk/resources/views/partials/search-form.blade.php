@php($searchValue = $search ?? '')
@php($perPageValue = $perPage ?? 10)

<form class="table-search" method="GET" action="{{ url()->current() }}">
  <div class="filter-field filter-field-search">
    <label for="{{ $id ?? 'table' }}-search">Search</label>
    <input id="{{ $id ?? 'table' }}-search" type="search" name="search" value="{{ $searchValue }}" placeholder="{{ $placeholder ?? 'Search' }}" aria-label="{{ $placeholder ?? 'Search' }}">
  </div>

  @if (($showDateFilters ?? false) === true)
    <div class="filter-field">
      <label for="{{ $id ?? 'table' }}-date-from">From</label>
      <input id="{{ $id ?? 'table' }}-date-from" type="date" name="date_from" value="{{ $dateFrom ?? '' }}">
    </div>

    <div class="filter-field">
      <label for="{{ $id ?? 'table' }}-date-to">To</label>
      <input id="{{ $id ?? 'table' }}-date-to" type="date" name="date_to" value="{{ $dateTo ?? '' }}">
    </div>
  @endif

  <div class="filter-field filter-field-small">
    <label for="{{ $id ?? 'table' }}-per-page">Show</label>
    <select id="{{ $id ?? 'table' }}-per-page" name="per_page">
      @foreach ([10, 20, 50, 100] as $option)
        <option value="{{ $option }}" @selected((int) $perPageValue === $option)>{{ $option }}</option>
      @endforeach
    </select>
  </div>

  <button class="button button-secondary" type="submit">Search</button>

  @if ($searchValue !== '' || ($dateFrom ?? '') !== '' || ($dateTo ?? '') !== '' || (int) $perPageValue !== 10)
    <a class="button button-secondary" href="{{ url()->current() }}">Clear</a>
  @endif
</form>
