@props(['date' => '', 'time' => '', 'title' => '', 'description' => ''])

<div class="flex gap-4 p-4 bg-white border border-surface-border rounded-xl hover:shadow-card transition-shadow">
    <div class="flex-shrink-0 w-14 h-14 bg-primary-50 rounded-xl flex flex-col items-center justify-center">
        <span class="text-xs font-medium text-primary-600">{{ \Carbon\Carbon::parse($date)->format('M') }}</span>
        <span class="text-lg font-bold text-primary-700">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
    </div>
    <div class="flex-1 min-w-0">
        <h4 class="text-sm font-semibold text-text-primary">{{ $title }}</h4>
        @if($description)
            <p class="text-sm text-text-muted mt-0.5 truncate">{{ $description }}</p>
        @endif
        @if($time)
            <div class="flex items-center gap-1 mt-2">
                <svg class="w-3.5 h-3.5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs text-text-muted">{{ $time }}</span>
            </div>
        @endif
    </div>
    <div class="flex-shrink-0">
        {{ $actions ?? '' }}
    </div>
</div>
