@if ($paginator->hasPages())
<div class="product-pagination">
    <div class="theme-paggination-block">
        <div class="row">
            <div class="col-xl-6 col-md-6 col-sm-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true"><i
                                        class="fa fa-chevron-left"
                                        aria-hidden="true"></i></span> <span
                                    class="sr-only">Geri</span></a></li>

                        @foreach ($elements as $element)
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                    <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                                    @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true"><i
                                        class="fa fa-chevron-right"
                                        aria-hidden="true"></i></span> <span
                                    class="sr-only">İleri</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endif
