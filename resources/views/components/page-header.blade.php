@props(['title' => '', 'icon' => ''])

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-text-primary">{{ $title }}</h2>
        @if(isset($subtitle))
            <p class="text-sm text-text-muted mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="flex items-center gap-2">
        {{ $actions ?? '' }}
    </div>
</div>
