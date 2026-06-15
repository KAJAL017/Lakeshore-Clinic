@props(['label' => '', 'checked' => false])

<label class="inline-flex items-center gap-2 cursor-pointer">
    <button type="button" role="switch" aria-checked="{{ $checked ? 'true' : 'false' }}" {{ $attributes->merge(['class' => 'relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 ' . ($checked ? 'bg-primary-600' : 'bg-gray-200')]) }}>
        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $checked ? 'translate-x-6' : 'translate-x-1' }}"></span>
    </button>
    @if($label)
        <span class="text-sm text-text-primary">{{ $label }}</span>
    @endif
</label>
