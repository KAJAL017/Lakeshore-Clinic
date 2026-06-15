@props(['lines' => 3])

<div class="space-y-3">
    @for($i = 0; $i < $lines; $i++)
        <div class="h-4 skeleton rounded {{ $i === $lines - 1 ? 'w-2/3' : 'w-full' }}"></div>
    @endfor
</div>
