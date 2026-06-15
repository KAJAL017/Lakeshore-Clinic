@props(['variant' => 'default'])

@php
$variants = [
    'default' => 'bg-gray-100 text-gray-800',
    'primary' => 'bg-primary-100 text-primary-800',
    'success' => 'bg-health-100 text-health-800',
    'warning' => 'bg-amber-100 text-amber-800',
    'danger' => 'bg-red-100 text-red-800',
    'info' => 'bg-blue-100 text-blue-800',
];

$classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
