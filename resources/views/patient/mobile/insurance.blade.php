@extends('layouts.patient-mobile')

@section('title', 'Insurance - Lakeshore Clinic')
@section('page-title', 'Insurance')

@section('content')
<div class="space-y-4">
    @forelse($insuranceRequests as $request)
    <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
        <div class="flex items-center justify-between mb-2">
            <span class="px-2 py-1 text-xs font-medium {{ $request->status === 'approved' ? 'bg-health-100 text-health-700' : ($request->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }} rounded-full">{{ ucfirst($request->status) }}</span>
            <span class="text-sm font-medium text-text-primary font-mono">{{ $request->insurance_number }}</span>
        </div>
        <p class="text-sm text-text-muted mb-1">{{ $request->insurance_provider ?? '-' }}</p>
        <p class="text-xs text-text-muted">{{ $request->created_at->format('M d, Y') }}</p>
    </div>
    @empty
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-text-muted mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <p class="text-text-muted">No insurance requests</p>
    </div>
    @endforelse
</div>
@endsection
