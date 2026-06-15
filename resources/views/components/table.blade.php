@props(['columns' => [], 'striped' => false, 'hoverable' => true])

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-surface-border">
                @foreach($columns as $column)
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                        {{ $column }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-surface-border">
            {{ $slot }}
        </tbody>
    </table>
</div>
