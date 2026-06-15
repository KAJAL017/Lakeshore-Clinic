@props(['label' => '', 'checked' => false])

<label class="inline-flex items-center gap-2 cursor-pointer">
    <input type="checkbox" {{ $attributes->merge(['class' => 'w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 transition-colors']) }} {{ $checked ? 'checked' : '' }}>
    @if($label)
        <span class="text-sm text-text-primary">{{ $label }}</span>
    @endif
</label>
