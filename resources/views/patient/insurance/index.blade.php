@extends('layouts.patient')

@section('title', 'Insurance - Lakeshore Clinic')
@section('page-title', 'My Insurance')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Insurance">
        <x-slot name="subtitle">View and manage your insurance requests</x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Insurance Number</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Provider</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Appointment</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($insuranceRequests as $request)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3 text-sm text-text-primary font-mono">{{ $request->insurance_number }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $request->insurance_provider ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $request->appointment?->type_label ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($request->status) {
                                        'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'cancelled' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$request->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $request->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
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
@endsection
