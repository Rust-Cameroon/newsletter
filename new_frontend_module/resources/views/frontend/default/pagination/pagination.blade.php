@if ($paginator->hasPages())
<div class="row justify-content-center">
    <div class="col-xxl-12">
        <div data-aos="fade-up" data-aos-duration="2000" class="basic-pagination text-center">
            <nav>
                <ul>
                    @if (!$paginator->onFirstPage())
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}">
                            <svg width="16" height="11" viewBox="0 0 16 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.17749 10.105L1.62499 5.55248L6.17749 0.999981" stroke="currentColor"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M14.3767 5.55249L1.75421 5.55249" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    @endif
                    
                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="current">{{ $page }}</span>
                                </li>
                                @else
                                <li>
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}">
                            <svg width="16" height="11" viewBox="0 0 16 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.82422 1L14.3767 5.5525L9.82422 10.105" stroke="currentColor"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M1.625 5.55249H14.2475" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
@endif
