@extends('layouts.app')

@section('title', 'Doctor Registrations - Lakeshore Clinic')
@section('page-title', 'Doctor Registrations')

@section('content')
<div class="space-y-6">
    <x-page-header title="Doctor Registrations">
        <x-slot name="subtitle">Review and manage doctor registration requests</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by name, email, license..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">License</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Qualification</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $reg->name }}</p>
                                <p class="text-xs text-text-muted">{{ $reg->email }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted font-mono">{{ $reg->license_number ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $reg->qualification ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($reg->status) {
                                        'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$reg->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $reg->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if($reg->status === 'pending')
                                        <button onclick="approveRegistration({{ $reg->id }})" class="px-3 py-1.5 text-sm font-medium text-health-600 bg-health-50 rounded-lg hover:bg-health-100 transition-colors">Approve</button>
                                        <button onclick="rejectRegistration({{ $reg->id }})" class="px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Reject</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No registration requests found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($registrations->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $registrations->links() }}
            </div>
        @endif
    </x-card>
</div>

@push('scripts')
<script>
async function approveRegistration(id) {
    try {
        const response = await fetch(`/admin/registrations/${id}/approve`, {
            method: 'PUT',
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
        } else {
            showToast(data.message || 'Failed to approve.', 'error');
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    }
}

async function rejectRegistration(id) {
    confirmAction('Are you sure you want to reject this registration?', async () => {
        try {
            const response = await fetch(`/admin/registrations/${id}/reject`, {
                method: 'PUT',
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
