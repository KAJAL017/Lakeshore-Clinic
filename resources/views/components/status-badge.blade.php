@props(['variant' => 'default', 'label' => ''])

@php
$variants = [
    'default' => 'bg-gray-100 text-gray-700',
    'pending' => 'bg-amber-100 text-amber-700',
    'active' => 'bg-health-100 text-health-700',
    'completed' => 'bg-primary-100 text-primary-700',
    'cancelled' => 'bg-red-100 text-red-700',
    'scheduled' => 'bg-blue-100 text-blue-700',
    'warning' => 'bg-amber-100 text-amber-700',
    'info' => 'bg-blue-100 text-blue-700',
    'success' => 'bg-health-100 text-health-700',
    'danger' => 'bg-red-100 text-red-700',
];

$classes = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ in_array($variant, ['active', 'completed']) ? 'bg-current' : 'bg-current opacity-60' }}"></span>
    {{ $label ?: ucfirst($variant) }}
</span>
