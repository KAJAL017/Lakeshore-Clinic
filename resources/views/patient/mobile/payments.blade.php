@extends('layouts.patient-mobile')

@section('title', 'Payments - Lakeshore Clinic')
@section('page-title', 'Payments')

@section('content')
<div class="space-y-4">
    @forelse($payments as $payment)
    <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
        <div class="flex items-center justify-between mb-2">
            <span class="px-2 py-1 text-xs font-medium {{ $payment->status === 'paid' ? 'bg-health-100 text-health-700' : 'bg-amber-100 text-amber-700' }} rounded-full">{{ ucfirst($payment->status) }}</span>
            <span class="text-lg font-bold text-text-primary">${{ number_format($payment->amount, 2) }}</span>
        </div>
        <p class="text-sm text-text-muted mb-1">{{ $payment->method_label }}</p>
        <p class="text-xs text-text-muted">{{ $payment->created_at->format('M d, Y') }}</p>
    </div>
    @empty
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-text-muted mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        <p class="text-text-muted">No payment history</p>
    </div>
    @endforelse
</div>
@endsection
