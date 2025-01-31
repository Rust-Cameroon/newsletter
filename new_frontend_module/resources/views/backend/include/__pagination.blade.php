<div class="site-pagination">
    <nav aria-label="...">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link">Prev</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" rel="prev" href="{{ $paginator->previousPageUrl() . (Str::contains($paginator->previousPageUrl(), '?') ? '&' : '?') . http_build_query(request()->except(['page'])) }}">
                        Prev
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item"><span class="page-link">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url . (Str::contains($url, '?') ? '&' : '?') . http_build_query(request()->except(['page'])) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" rel="next" href="{{ $paginator->nextPageUrl() . (Str::contains($paginator->nextPageUrl(), '?') ? '&' : '?') . http_build_query(request()->except(['page'])) }}">
                        Next
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#">Next</a>
                </li>
            @endif

        </ul>
    </nav>
</div>
