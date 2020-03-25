@if ($paginator->hasPages())
    <nav class="nav-pagination">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="ls-disabled"><a href="#"></a></li>
            @else
                <li class="page-item prev"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"> Anterior <i
                                class="fa fa-angle-double-left ml-2" aria-hidden="true"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="ls-disabled"><a href="#" class="page-link">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a href="#" class="page-link">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item next"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i
                                class="fa fa-angle-double-right mr-2" aria-hidden="true"></i> Próximo</a></li>
            @else
                <li class="ls-disabled"><a href="#"></a></li>
            @endif
        </ul>
    </nav>
@endif
