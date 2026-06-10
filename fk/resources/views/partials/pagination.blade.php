<nav class="pagination" aria-label="Pagination">
  <div class="pagination-meta">
    <div class="pagination-summary">
      @if ($paginator->total() > 0)
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }}
      @else
        No records found
      @endif
    </div>

    @if ($paginator->total() > 0)
      <div class="pagination-links">
        @if ($paginator->onFirstPage())
          <span class="pagination-link is-disabled">Previous</span>
        @else
          <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
        @endif

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
          @if ($page === $paginator->currentPage())
            <span class="pagination-link is-active">{{ $page }}</span>
          @else
            <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        @if ($paginator->hasMorePages())
          <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
        @else
          <span class="pagination-link is-disabled">Next</span>
        @endif
      </div>
    @endif
  </div>
</nav>
