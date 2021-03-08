<?php
$numPageShow = 5;
$totalPage = $paginator->lastPage();
if ($paginator->currentPage() > ($numPageShow / 2)) {
    $startPage = $paginator->currentPage() - floor($numPageShow / 2);
    if ($totalPage - $startPage < $numPageShow) {
        $startPage = $totalPage - $numPageShow + 1;
    }
} else {
    $startPage = 1;
}
if ($startPage < 1) {
    $startPage = 1;
}
$gets = request()->all();
$except = ['page'];
$url = '';
foreach ($gets as $key => $value) {
    if (!in_array($key, $except)) {
        if (!is_array($value)) {
            $url .= (($url) ? '&' : '') . urlencode($key) . '=' . urlencode($value);
        } else {
            foreach ($value as $key2 => $value2) {
                $url .= (($url) ? '&' : '') . urlencode($key.'['.$key2.']') . '=' . urlencode($value2);
            }
        }
    }
}

$unp = url()->current() . '?' . $url . ($url ? '&' : '');
?>
@if ($paginator->hasPages())
    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item pagination-first disabled"><a class="page-link" href="#"></a></li>
                <li class="page-item pagination-prev disabled"><a class="page-link" href="#"></a></li>
            @else
                <li class="page-item pagination-first"><a class="page-link" href="{{ $unp . 'page=1' }}"></a></li>
                <li class="page-item pagination-prev"><a class="page-link" href="{{ $unp . 'page=' . ($paginator->currentPage() - 1) }}"></a></li>
            @endif

            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link" href="javascript:void(0)">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $unp . 'page=' . $page }}">{{ $page }}</a></li>
                            @if ($startPage > 2 && $page == 2)
                                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item pagination-next"><a class="page-link" href="{{ $unp . 'page=' . ($paginator->currentPage() + 1) }}"></a></li>
                <li class="page-item pagination-last"><a class="page-link" href="{{ $unp . 'page=' . $paginator->lastPage() }}"></a></li>
            @else
                <li class="page-item pagination-next disabled"><a class="page-link" href="#"></a></li>
                <li class="page-item pagination-last disabled"><a class="page-link" href="#"></a></li>
            @endif
        </ul>
    </nav>
@endif
