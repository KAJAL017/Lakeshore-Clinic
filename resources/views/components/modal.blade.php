@props(['id' => '', 'title' => '', 'size' => 'md'])

@php
$sizes = [
    'sm' => 'max-w-md',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
];
@endphp

<div id="modal-{{ $id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50" data-modal-backdrop>
    <div class="bg-white rounded-xl shadow-modal {{ $sizes[$size] ?? $sizes['md'] }} w-full mx-4 fade-in">
        @if($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-surface-border">
                <h3 class="text-lg font-semibold text-text-primary">{{ $title }}</h3>
                <button data-modal-close class="text-text-muted hover:text-text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
        <div class="px-6 py-4">
            {{ $slot }}
        </div>
        @if(isset($footer))
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-surface-border">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
