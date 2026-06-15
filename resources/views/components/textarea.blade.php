@props(['label' => '', 'error' => '', 'required' => false])

<div class="space-y-1.5">
    @if($label)
        <label class="block text-sm font-medium text-text-primary">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <textarea {{ $attributes->merge(['class' => 'w-full px-3 py-2 text-sm bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors resize-none ' . ($error ? 'border-red-500' : 'border-surface-border')]) }} rows="3">{{ $slot }}</textarea>
    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
