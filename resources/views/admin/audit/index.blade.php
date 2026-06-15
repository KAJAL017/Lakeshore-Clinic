@extends('layouts.app')

@section('title', 'Audit Logs - Lakeshore Clinic')
@section('page-title', 'Audit Logs')

@section('content')
<div class="space-y-6">
    <x-page-header title="Audit Logs">
        <x-slot name="subtitle">View system activity and audit trail</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by user, action, module..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="module" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Modules</option>
                    <option value="auth" {{ request('module') === 'auth' ? 'selected' : '' }}>Authentication</option>
                    <option value="appointment" {{ request('module') === 'appointment' ? 'selected' : '' }}>Appointments</option>
                    <option value="patient" {{ request('module') === 'patient' ? 'selected' : '' }}>Patients</option>
                    <option value="doctor" {{ request('module') === 'doctor' ? 'selected' : '' }}>Doctors</option>
                    <option value="payment" {{ request('module') === 'payment' ? 'selected' : '' }}>Payments</option>
                    <option value="insurance" {{ request('module') === 'insurance' ? 'selected' : '' }}>Insurance</option>
                    <option value="settings" {{ request('module') === 'settings' ? 'selected' : '' }}>Settings</option>
                    <option value="system" {{ request('module') === 'system' ? 'selected' : '' }}>System</option>
                </select>
                <select name="action" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Actions</option>
                    <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="approve" {{ request('action') === 'approve' ? 'selected' : '' }}>Approve</option>
                    <option value="reject" {{ request('action') === 'reject' ? 'selected' : '' }}>Reject</option>
                    <option value="status_change" {{ request('action') === 'status_change' ? 'selected' : '' }}>Status Change</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Module</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($auditLogs as $log)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $log->user?->name ?? 'System' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $actionVariant = match($log->action) {
                                        'login', 'logout' => 'info',
                                        'create' => 'success',
                                        'update', 'status_change' => 'warning',
                                        'delete' => 'danger',
                                        'approve' => 'success',
                                        'reject' => 'danger',
                                        default => 'default',
                                    };
                                @endphp
                                <x-badge :variant="$actionVariant">{{ $log->action_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ ucfirst($log->module) }}</td>
                            <td class="px-4 py-3 text-sm text-text-primary max-w-xs truncate">{{ $log->description ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted font-mono">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No audit logs found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($auditLogs->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection
