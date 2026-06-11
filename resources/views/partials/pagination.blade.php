@if ($paginator->hasPages())
    @php
        $lastPage = $paginator->lastPage();
        $currentPage = $paginator->currentPage();
        
        if ($lastPage <= 7) {
            $pages = range(1, $lastPage);
        } else {
            $pages = [];
            $pages[] = 1;
            
            if ($currentPage > 3) {
                $pages[] = '...';
            }
            
            $start = max(2, $currentPage - 1);
            $end = min($lastPage - 1, $currentPage + 1);
            
            $adjustedStart = $start;
            $adjustedEnd = $end;
            if ($currentPage <= 3) {
                $adjustedEnd = min($lastPage - 1, 4);
            } elseif ($currentPage >= $lastPage - 2) {
                $adjustedStart = max(2, $lastPage - 3);
            }
            
            for ($i = $adjustedStart; $i <= $adjustedEnd; $i++) {
                $pages[] = $i;
            }
            
            if ($currentPage < $lastPage - 2) {
                $pages[] = '...';
            }
            
            $pages[] = $lastPage;
        }
    @endphp

    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between font-sans">
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-stone-400 bg-white border border-stone-200 cursor-default rounded-xl">
                    « Trước
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-stone-700 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition-colors">
                    « Trước
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-stone-700 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition-colors">
                    Sau »
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-stone-400 bg-white border border-stone-200 cursor-default rounded-xl">
                    Sau »
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between w-full">
            <div>
                <p class="text-xs text-stone-500 font-medium">
                    Hiển thị từ <span class="font-bold text-stone-900">{{ $paginator->firstItem() }}</span> đến <span class="font-bold text-stone-900">{{ $paginator->lastItem() }}</span> trong tổng số <span class="font-bold text-stone-900">{{ $paginator->total() }}</span> kết quả
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-xl gap-1.5">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center justify-center w-10 h-10 bg-stone-50 border border-stone-200 text-stone-300 cursor-default rounded-xl" aria-hidden="true">
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" class="relative inline-flex items-center justify-center w-10 h-10 bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors rounded-xl">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($pages as $page)
                        {{-- "Three Dots" Separator --}}
                        @if ($page === '...')
                            <span aria-disabled="true" class="relative inline-flex items-center justify-center w-10 h-10 text-stone-400 font-bold">
                                ...
                            </span>
                        @else
                            @if ($page == $currentPage)
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center justify-center w-10 h-10 bg-amber-700 border border-amber-700 text-white font-bold rounded-xl shadow-md shadow-amber-900/10">
                                        {{ $page }}
                                    </span>
                                </span>
                            @else
                                <a href="{{ $paginator->url($page) }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" class="relative inline-flex items-center justify-center w-10 h-10 bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 font-bold rounded-xl transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" class="relative inline-flex items-center justify-center w-10 h-10 bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors rounded-xl">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center justify-center w-10 h-10 bg-stone-50 border border-stone-200 text-stone-300 cursor-default rounded-xl" aria-hidden="true">
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
    <script>
        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>
@endif
