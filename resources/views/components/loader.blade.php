@props(['size' => 'md'])

@php
$sizes = [
    'sm' => 'w-4 h-4 border-2',
    'md' => 'w-6 h-6 border-2',
    'lg' => 'w-8 h-8 border-3',
];
@endphp

<div {{ $attributes->merge(['class' => ($sizes[$size] ?? $sizes['md']) . ' border-primary-500 border-t-transparent rounded-full animate-spin']) }}></div>
