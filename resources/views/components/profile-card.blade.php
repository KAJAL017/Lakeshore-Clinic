@props(['title' => '', 'content' => '', 'avatar' => '', 'time' => ''])

<div class="flex gap-3 p-4 hover:bg-surface rounded-lg transition-colors">
    <x-avatar :src="$avatar" initials="U" size="sm" />
    <div class="flex-1 min-w-0">
        <p class="text-sm text-text-primary">{{ $content }}</p>
        @if($time)
            <p class="text-xs text-text-muted mt-1">{{ $time }}</p>
        @endif
    </div>
</div>
