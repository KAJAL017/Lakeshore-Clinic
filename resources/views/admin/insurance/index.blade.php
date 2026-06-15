@extends('layouts.app')

@section('title', 'Insurance - Lakeshore Clinic')
@section('page-title', 'Insurance Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Insurance Management">
        <x-slot name="subtitle">Review and manage insurance requests</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by insurance number, patient..." value="{{ request('search') }}" />
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Insurance Number</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Provider</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($insuranceRequests as $request)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $request->patient?->first_name . ' ' . $request->patient?->last_name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted font-mono">{{ $request->insurance_number }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $request->insurance_provider ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $request->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($request->status) {
                                        'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'cancelled' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$request->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewInsurance({{ $request->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    @if($request->status === 'pending')
                                        <button onclick="approveInsurance({{ $request->id }})" class="w-8 h-8 rounded-lg hover:bg-health-50 flex items-center justify-center transition-colors" title="Approve">
                                            <svg class="w-4 h-4 text-health-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <button onclick="rejectInsurance({{ $request->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Reject">
                                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No insurance requests found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($insuranceRequests->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $insuranceRequests->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-insurance" title="Insurance Details">
    <div id="insurance-content" class="space-y-4"></div>
</x-modal>

<x-modal id="review-insurance" title="Review Insurance Request">
    <form id="review-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="insurance_id" id="review-insurance-id">
        <input type="hidden" name="action" id="review-action">
        <x-textarea label="Admin Notes" name="admin_notes" rows="3" placeholder="Add notes about this decision..." />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="review-btn" onclick="submitReview()">
            <span id="review-btn-text">Submit</span>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function viewInsurance(id) {
    try {
        const response = await fetch(`/admin/insurance/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const i = data.insuranceRequest;
            const statusColors = { pending: 'bg-amber-100 text-amber-800', approved: 'bg-health-100 text-health-800', rejected: 'bg-red-100 text-red-800', cancelled: 'bg-red-100 text-red-800' };

            document.getElementById('insurance-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[i.status] || 'bg-gray-100 text-gray-800'}">${i.status_label}</span></div>
                    <div><p class="text-text-muted mb-1">Patient</p><p class="text-text-primary font-medium">${i.patient ? i.patient.first_name + ' ' + i.patient.last_name : '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Insurance Number</p><p class="text-text-primary font-mono">${i.insurance_number}</p></div>
                    <div><p class="text-text-muted mb-1">Provider</p><p class="text-text-primary">${i.insurance_provider || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Submitted</p><p class="text-text-primary">${new Date(i.created_at).toLocaleDateString()}</p></div>
                    ${i.admin_notes ? `<div class="col-span-2"><p class="text-text-muted mb-1">Admin Notes</p><p class="text-text-primary">${i.admin_notes}</p></div>` : ''}
                </div>
            `;
            openModal('modal-view-insurance');
        }
    } catch (error) {
        showToast('Failed to load details.', 'error');
    }
}

function approveInsurance(id) {
    document.getElementById('review-insurance-id').value = id;
    document.getElementById('review-action').value = 'approve';
    openModal('modal-review-insurance');
}

function rejectInsurance(id) {
    document.getElementById('review-insurance-id').value = id;
    document.getElementById('review-action').value = 'reject';
    openModal('modal-review-insurance');
}

async function submitReview() {
    const id = document.getElementById('review-insurance-id').value;
    const action = document.getElementById('review-action').value;
    const notes = document.querySelector('#review-form textarea[name="admin_notes"]').value;

    try {
        const response = await fetch(`/admin/insurance/${id}/${action}`, {
            method: 'PUT',
            body: JSON.stringify({ admin_notes: notes }),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
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
}
</script>
@endpush
@endsection
