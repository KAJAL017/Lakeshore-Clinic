@props(['variant' => 'default', 'class' => ''])

@php
$variants = [
    'default' => 'bg-white border border-surface-border',
    'hover' => 'bg-white border border-surface-border hover:shadow-card-hover transition-shadow',
    'flat' => 'bg-surface',
    'primary' => 'bg-primary-50 border border-primary-100',
    'success' => 'bg-health-50 border border-health-100',
    'warning' => 'bg-amber-50 border border-amber-100',
    'danger' => 'bg-red-50 border border-red-100',
];

$classes = 'rounded-xl ' . ($variants[$variant] ?? $variants['default']) . ' ' . $class;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
