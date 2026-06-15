@props(['label' => '', 'class' => ''])

<tr {{ $attributes->merge(['class' => ($hoverable ? 'hover:bg-surface transition-colors' : '') . ' ' . $class]) }}>
    {{ $slot }}
</tr>
