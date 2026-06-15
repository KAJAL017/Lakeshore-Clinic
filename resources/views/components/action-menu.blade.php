@props(['items' => []])

<div class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100 transition-colors relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center justify-center w-full h-full">
        <svg class="w-5 h-5 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-dropdown border border-surface-border overflow-hidden z-10">
        @foreach($items as $item)
            @if(isset($item['divider']))
                <div class="border-t border-surface-border"></div>
            @else
                <a href="{{ $item['url'] ?? '#' }}" class="flex items-center gap-2 px-4 py-2 text-sm {{ $item['danger'] ?? false ? 'text-red-600 hover:bg-red-50' : 'text-text-secondary hover:bg-surface' }} transition-colors">
                    @if(isset($item['icon']))
                        <span class="w-4 h-4">{!! $item['icon'] !!}</span>
                    @endif
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </div>
</div>
