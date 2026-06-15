@props(['label' => 'Filters'])

<div class="flex items-center gap-3 p-4 bg-white border border-surface-border rounded-xl">
    <div class="flex items-center gap-2 text-text-secondary">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
        </svg>
        <span class="text-sm font-medium">{{ $label }}</span>
    </div>
    <div class="flex-1 flex items-center gap-3">
        {{ $slot }}
    </div>
</div>
