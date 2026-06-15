@props(['size' => 'md', 'src' => '', 'alt' => '', 'initials' => '', 'color' => 'primary'])

@php
$sizes = [
    'xs' => 'w-6 h-6 text-xs',
    'sm' => 'w-8 h-8 text-sm',
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-12 h-12 text-base',
    'xl' => 'w-16 h-16 text-lg',
];

$colors = [
    'primary' => 'bg-primary-100 text-primary-700',
    'success' => 'bg-health-100 text-health-700',
    'warning' => 'bg-amber-100 text-amber-700',
    'danger' => 'bg-red-100 text-red-700',
    'gray' => 'bg-gray-100 text-gray-700',
];

$classes = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'relative inline-flex items-center justify-center rounded-full overflow-hidden ' . $classes]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full flex items-center justify-center {{ $colors[$color] ?? $colors['primary'] }}">
            <span class="font-medium">{{ $initials }}</span>
        </div>
    @endif
</div>
