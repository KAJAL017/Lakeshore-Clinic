@props(['value' => 0, 'label' => '', 'icon' => '', 'trend' => '', 'trendDirection' => 'up', 'color' => 'primary'])

@php
$colors = [
    'primary' => 'bg-primary-500/10 text-primary-600',
    'success' => 'bg-health-500/10 text-health-600',
    'warning' => 'bg-amber-500/10 text-amber-600',
    'danger' => 'bg-red-500/10 text-red-600',
];
@endphp

<x-card variant="hover" class="p-6">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-text-muted">{{ $label }}</p>
            <p class="text-2xl font-bold text-text-primary mt-1">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="w-12 h-12 rounded-xl {{ $colors[$color] ?? $colors['primary'] }} flex items-center justify-center">
                {!! $icon !!}
            </div>
        @endif
    </div>
    @if($trend)
        <div class="flex items-center gap-1 mt-3">
            @if($trendDirection === 'up')
                <svg class="w-4 h-4 text-health-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium text-health-600">{{ $trend }}</span>
            @else
                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium text-red-600">{{ $trend }}</span>
            @endif
        </div>
    @endif
</x-card>
