@props(['items' => []])

@if(count($items) > 0)
<nav class="flex items-center gap-2 text-sm">
    @foreach($items as $index => $item)
        @if($index > 0)
            <svg class="w-4 h-4 text-text-muted flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        @endif
        @if(isset($item['url']))
            <a href="{{ $item['url'] }}" class="text-text-muted hover:text-primary-600 transition-colors">{{ $item['label'] }}</a>
        @else
            <span class="text-text-primary font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
@endif
