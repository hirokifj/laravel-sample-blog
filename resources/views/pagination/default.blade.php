@if ($paginator->hasPages())
    <div class="pagination">
        <ul class="pagination__list">

            @if (!$paginator->onFirstPage())
                <li class="pagination__item"><a href="{{ $paginator->previousPageUrl() }}" class="pagination__link"><i class="fas fa-angle-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination__item pagination__item--dots" aria-disabled="true">{{ $element }}</li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item" aria-current="page"><span class="pagination__link page-active">{{ $page }}</span></li>
                        @else
                            <li class="pagination__item"><a class="pagination__link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="pagination__item"><a href="{{ $paginator->nextPageUrl() }}" class="pagination__link"><i class="fas fa-angle-right"></i></a></li>
            @endif
        </ul>
    </div>
@endif


