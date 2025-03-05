@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link border-0 bg-transparent text-dark" href="javascript:;" tabindex="-1">
                        <i class="fas fa-chevron-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 bg-transparent text-dark" href="{{ $paginator->previousPageUrl() }}">
                        <i class="fas fa-chevron-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 bg-transparent">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link bg-gradient-primary border-0">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 bg-transparent text-dark" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-0 bg-transparent text-dark" href="{{ $paginator->nextPageUrl() }}">
                        <i class="fas fa-chevron-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link border-0 bg-transparent text-dark" href="javascript:;" tabindex="-1">
                        <i class="fas fa-chevron-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="d-flex justify-content-center align-items-center mt-3">
        <p class="text-sm text-gray-700 leading-5 mb-0">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </p>
    </div>
@endif

<style>
.pagination {
    margin-bottom: 0;
}

.page-link {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.15s ease-in;
}

.page-link:hover {
    background: #f6f9fc;
}

.page-item.active .page-link {
    box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
}

.page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-item:not(:first-child) .page-link {
    margin-left: 0.25rem;
}

.page-item:first-child .page-link,
.page-item:last-child .page-link {
    padding: 0.75rem;
}
</style> 