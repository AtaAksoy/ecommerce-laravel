<div class="jsgrid-pager-container" style="">
    <div class="jsgrid-pager">
        Sayfalar:
        @if ($paginator->hasPages())
        @if ($paginator->onFirstPage())
            <span class="jsgrid-pager-nav-button jsgrid-pager-nav-inactive-button">
                <a href="javascript:void(0);">İlk</a>
            </span>
            <span class="jsgrid-pager-nav-button jsgrid-pager-nav-inactive-button">
                <a href="javascript:void(0)">Önceki</a>
            </span>
        @else
            <span class="jsgrid-pager-nav-button jsgrid-pager-nav-active-button">
                <a href="{{ $paginator->url(1) }}">İlk</a>
            </span>
            <span class="jsgrid-pager-nav-button jsgrid-pager-nav-active-button">
                <a href="{{ $paginator->previousPageUrl() }}">Önceki</a>
            </span>
        @endif
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <span class="jsgrid-pager-page jsgrid-pager-current-page">{{ $page }}</span>
                    @else
                    <span class="jsgrid-pager-page">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </span>
                    @endif
                @endforeach
            @endif
        @endforeach
            @if ($paginator->hasMorePages())
            <span class="jsgrid-pager-nav-button">
                <a href="{{ $paginator->nextPageUrl() }}">Sonraki</a>
            </span>
            @else
            <span class="jsgrid-pager-nav-button jsgrid-pager-nav-inactive-button">
                <a href="javascript:void(0)">Sonraki</a>
            </span>
            @endif
        @endif
    </div>
</div>
