@extends('layouts.app')

@section('title', 'Backup Management - Lakeshore Clinic')
@section('page-title', 'Backup Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Backup Management">
        <x-slot name="subtitle">Manage system backups and recovery</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" onclick="createBackup()">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Create Backup
            </x-button>
        </x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by type, status..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="backup_type" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="database" {{ request('backup_type') === 'database' ? 'selected' : '' }}>Database</option>
                    <option value="system" {{ request('backup_type') === 'system' ? 'selected' : '' }}>System</option>
                    <option value="configuration" {{ request('backup_type') === 'configuration' ? 'selected' : '' }}>Configuration</option>
                </select>
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="running" {{ request('status') === 'running' ? 'selected' : '' }}>Running</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <x-button variant="primary" size="sm" type="submit">Filter</x-button>
            </div>
        </form>
    </x-card>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Duration</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($backupLogs as $log)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                @php
                                    $typeVariant = match($log->backup_type) {
                                        'database' => 'primary', 'system' => 'info', 'configuration' => 'warning', default => 'default',
                                    };
                                @endphp
                                <x-badge :variant="$typeVariant">{{ $log->type_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($log->status) {
                                        'pending' => 'warning', 'running' => 'info', 'completed' => 'success', 'failed' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$log->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $log->duration ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted max-w-xs truncate">{{ $log->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <x-empty-state message="No backup logs found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($backupLogs->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $backupLogs->links() }}
            </div>
        @endif
    </x-card>
</div>

@push('scripts')
<script>
async function createBackup() {
    confirmAction('Are you sure you want to create a new backup?', async () => {
        try {
            const response = await fetch('{{ route("admin.backup.create") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            }
        } catch (error) {
            showToast('An error occurred.', 'error');
        }
    });
}
</script>
@endpush
@endsection
