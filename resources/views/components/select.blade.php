@props(['label' => '', 'error' => '', 'required' => false, 'options' => [], 'placeholder' => ''])

<div class="space-y-1.5">
    @if($label)
        <label class="block text-sm font-medium text-text-primary">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <select {{ $attributes->merge(['class' => 'w-full px-3 py-2 text-sm bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors appearance-none bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5rem_1.5rem] bg-[url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%2394a3b8\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E")] ' . ($error ? 'border-red-500' : 'border-surface-border')]) }}>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
        {{ $slot }}
    </select>
    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
