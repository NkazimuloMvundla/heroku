@if($pager->lastPage() != 1)
<ul class="pagination">

    @unless($pager->currentPage() < 3)
        <li class="paginate_button previous">
            <a href="{{ $pager->url(1) }}" title="First Page"><i class="fa fa-angle-double-left"></i></a>
        </li>
    @endunless

    <li class="paginate_button previous @unless($pager->previousPageUrl())disabled @endunless">
        <a href="{{ $pager->previousPageUrl() }}"><i class="fa fa-angle-left"></i></a>
    </li>

    @while($pager->paging++ < $pager->lastPage())
        @if (abs($pager->paging - $pager->currentPage()) >= 2)
            {{-- Generate relative links (eg. +10,etc) --}}
            @if(in_array(abs($pager->paging - $pager->currentPage()), array(10, 50, 100, 500, 1000))
            and $pager->paging != 1 and $pager->paging != $pager->lastPage())
                <li class="paginate_button @unless($pager->currentPage() != $pager->paging)active @endunless">
                    <a title="Results from {{ PaginationStartEnd($pager->paging, $pager->perPage(), $pager->total())['start'] }} to {{ PaginationStartEnd($pager->paging, $pager->perPage(), $pager->total())['end'] }} of {{ $pager->total() }}" href="{{ $pager->url($pager->paging) }}">
                        <!-- + {{ $pager->paging - $pager->currentPage() }} -->{{ $pager->paging }}
                    </a>
                </li>
            @endif
        @else
            <li class="paginate_button @unless($pager->currentPage() != $pager->paging)active @endunless">
                <a title="Results from {{ PaginationStartEnd($pager->paging, $pager->perPage(), $pager->total())['start'] }} to {{ PaginationStartEnd($pager->paging, $pager->perPage(), $pager->total())['end'] }} of {{ $pager->total() }}" href="{{ $pager->url($pager->paging) }}">
                    {{ $pager->paging }}
                </a>
            </li>
        @endif
    @endwhile

    <li class="paginate_button next @unless($pager->nextPageUrl())disabled @endunless">
        <a href="{{ $pager->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a>
    </li>

    @unless($pager->lastPage() - $pager->currentPage() < 2)
        <li class="paginate_button next">
            <a href="{{ $pager->url($pager->lastPage()) }}" title="Last Page"><i class="fa fa-angle-double-right"></i></a>
        </li>
    @endunless

</ul>
@endif 
