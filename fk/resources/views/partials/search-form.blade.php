@php($searchValue = $search ?? '')

<form class="table-search" method="GET" action="{{ url()->current() }}">
  <input type="search" name="search" value="{{ $searchValue }}" placeholder="{{ $placeholder ?? 'Search' }}" aria-label="{{ $placeholder ?? 'Search' }}">
  <button class="button button-secondary" type="submit">Search</button>

  @if ($searchValue !== '')
    <a class="button button-secondary" href="{{ url()->current() }}">Clear</a>
  @endif
</form>
