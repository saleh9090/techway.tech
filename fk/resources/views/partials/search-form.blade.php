@php($searchValue = $search ?? '')
@php($perPageValue = $perPage ?? 10)
@php($dateFromValue = $dateFrom ?? '')
@php($dateToValue = $dateTo ?? '')
@php($hasFilters = $searchValue !== '' || $dateFromValue !== '' || $dateToValue !== '')

<div class="table-controls">
  <form class="table-search" method="GET" action="{{ url()->current() }}">
    <input type="hidden" name="per_page" value="{{ $perPageValue }}">

    <div class="filter-field filter-field-search">
      <label for="{{ $id ?? 'table' }}-search">Search</label>
      <input id="{{ $id ?? 'table' }}-search" type="search" name="search" value="{{ $searchValue }}" placeholder="{{ $placeholder ?? 'Search' }}" aria-label="{{ $placeholder ?? 'Search' }}">
    </div>

    @if (($showDateFilters ?? false) === true)
      <div class="filter-field">
        <label for="{{ $id ?? 'table' }}-date-from">From</label>
        <input id="{{ $id ?? 'table' }}-date-from" type="date" name="date_from" value="{{ $dateFromValue }}">
      </div>

      <div class="filter-field">
        <label for="{{ $id ?? 'table' }}-date-to">To</label>
        <input id="{{ $id ?? 'table' }}-date-to" type="date" name="date_to" value="{{ $dateToValue }}">
      </div>
    @endif

    <button class="button button-secondary" type="submit">Search</button>

    @if ($hasFilters)
      <a class="button button-secondary" href="{{ url()->current() }}{{ (int) $perPageValue !== 10 ? '?per_page=' . $perPageValue : '' }}">Clear</a>
    @endif
  </form>

  <form class="table-page-size" method="GET" action="{{ url()->current() }}">
    @if ($searchValue !== '')
      <input type="hidden" name="search" value="{{ $searchValue }}">
    @endif
    @if (($showDateFilters ?? false) === true && $dateFromValue !== '')
      <input type="hidden" name="date_from" value="{{ $dateFromValue }}">
    @endif
    @if (($showDateFilters ?? false) === true && $dateToValue !== '')
      <input type="hidden" name="date_to" value="{{ $dateToValue }}">
    @endif

    <div class="filter-field filter-field-small">
      <label for="{{ $id ?? 'table' }}-per-page">Show</label>
      <select id="{{ $id ?? 'table' }}-per-page" name="per_page" onchange="this.form.submit()">
        @foreach ([10, 20, 50, 100] as $option)
          <option value="{{ $option }}" @selected((int) $perPageValue === $option)>{{ $option }}</option>
        @endforeach
      </select>
    </div>
  </form>
</div>
