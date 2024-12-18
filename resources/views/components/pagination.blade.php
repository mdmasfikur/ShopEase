@if($paginator->hasMorePages())
<div class="d-flex justify-content-center">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link">« Previous</span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                « Previous
            </a>
        </li>
        @endif

        {{-- Pagination Links --}}
        @for ($page = 1; $page <= $paginator->lastPage(); $page++)
            @if ($page == $paginator->currentPage())
            <li class="page-item active">
                <span class="page-link">{{ $page }}</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
            </li>
            @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    Next »
                </a>
            </li>
            @else
            <li class="page-item disabled">
                <span class="page-link">Next »</span>
            </li>
            @endif
    </ul>
</div>
@endif