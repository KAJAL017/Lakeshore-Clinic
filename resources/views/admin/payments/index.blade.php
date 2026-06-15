@extends('layouts.app')

@section('title', 'Payments - Lakeshore Clinic')
@section('page-title', 'Payment Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Payment Management">
        <x-slot name="subtitle">View and manage payments</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by transaction ID, patient..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <select name="payment_method" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Methods</option>
                    <option value="stripe" {{ request('payment_method') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="insurance" {{ request('payment_method') === 'insurance' ? 'selected' : '' }}>Insurance</option>
                    <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Transaction ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Method</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $payment->patient?->first_name . ' ' . $payment->patient?->last_name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted font-mono">{{ $payment->transaction_id ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-text-primary">${{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <x-badge variant="primary">{{ $payment->method_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($payment->status) {
                                        'pending' => 'warning', 'paid' => 'success', 'failed' => 'danger', 'cancelled' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$payment->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $payment->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewPayment({{ $payment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <x-empty-state message="No payments found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $payments->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-payment" title="Payment Details">
    <div id="payment-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewPayment(id) {
    try {
        const response = await fetch(`/admin/payments/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.payment;
            const statusColors = { pending: 'bg-amber-100 text-amber-800', paid: 'bg-health-100 text-health-800', failed: 'bg-red-100 text-red-800', cancelled: 'bg-red-100 text-red-800' };

            document.getElementById('payment-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[p.status] || 'bg-gray-100 text-gray-800'}">${p.status_label}</span></div>
                    <div><p class="text-text-muted mb-1">Patient</p><p class="text-text-primary font-medium">${p.patient ? p.patient.first_name + ' ' + p.patient.last_name : '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Amount</p><p class="text-text-primary font-medium text-lg">$${parseFloat(p.amount).toFixed(2)}</p></div>
                    <div><p class="text-text-muted mb-1">Transaction ID</p><p class="text-text-primary font-mono">${p.transaction_id || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Payment Method</p><p class="text-text-primary">${p.method_label}</p></div>
                    <div><p class="text-text-muted mb-1">Currency</p><p class="text-text-primary">${p.currency}</p></div>
                    <div><p class="text-text-muted mb-1">Date</p><p class="text-text-primary">${p.paid_at ? new Date(p.paid_at).toLocaleString() : '-'}</p></div>
                </div>
            `;
            openModal('modal-view-payment');
        }
    } catch (error) {
        showToast('Failed to load payment details.', 'error');
    }
}
</script>
@endpush
@endsection
