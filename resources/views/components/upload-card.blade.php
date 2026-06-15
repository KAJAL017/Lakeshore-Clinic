@props(['src' => '', 'alt' => '', 'placeholder' => ''])

<div class="border-2 border-dashed border-surface-border rounded-xl p-6 text-center hover:border-primary-400 transition-colors cursor-pointer">
    @if($src)
        <div class="relative">
            <img src="{{ $src }}" alt="{{ $alt }}" class="max-h-48 mx-auto rounded-lg">
            <button type="button" class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @else
        <div class="w-12 h-12 mx-auto rounded-full bg-surface flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-sm text-text-secondary mb-1">{{ $placeholder ?: 'Click to upload or drag and drop' }}</p>
        <p class="text-xs text-text-muted">PNG, JPG, GIF up to 10MB</p>
    @endif
</div>
