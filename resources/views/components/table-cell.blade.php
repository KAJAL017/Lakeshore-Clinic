@props(['class' => ''])

<td {{ $attributes->merge(['class' => 'px-4 py-3.5 text-sm text-text-primary whitespace-nowrap ' . $class]) }}>
    {{ $slot }}
</td>
