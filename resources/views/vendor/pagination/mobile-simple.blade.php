@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2">
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2.5 text-sm font-medium text-text-muted bg-white rounded-xl border border-surface-border opacity-50 cursor-not-allowed select-none">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2.5 text-sm font-medium text-[#0d9488] bg-[#0d9488]/10 rounded-xl active:bg-[#0d9488]/20 transition-colors">
                Previous
            </a>
        @endif

        <span class="px-3 py-2.5 text-sm font-medium text-text-secondary select-none">
            {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2.5 text-sm font-medium text-[#0d9488] bg-[#0d9488]/10 rounded-xl active:bg-[#0d9488]/20 transition-colors">
                Next
            </a>
        @else
            <span class="px-4 py-2.5 text-sm font-medium text-text-muted bg-white rounded-xl border border-surface-border opacity-50 cursor-not-allowed select-none">
                Next
            </span>
        @endif
    </nav>
@endif
