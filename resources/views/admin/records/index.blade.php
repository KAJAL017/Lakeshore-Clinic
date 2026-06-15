@extends('layouts.app')

@section('title', 'Patient Records - Lakeshore Clinic')
@section('page-title', 'Patient Records')

@section('content')
<div class="space-y-6">
    <x-page-header title="Patient Records">
        <x-slot name="subtitle">View patient medical documents and records</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by patient name..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="document_type" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="lab_report" {{ request('document_type') === 'lab_report' ? 'selected' : '' }}>Lab Report</option>
                    <option value="imaging" {{ request('document_type') === 'imaging' ? 'selected' : '' }}>Imaging</option>
                    <option value="prescription" {{ request('document_type') === 'prescription' ? 'selected' : '' }}>Prescription</option>
                    <option value="referral" {{ request('document_type') === 'referral' ? 'selected' : '' }}>Referral</option>
                    <option value="insurance" {{ request('document_type') === 'insurance' ? 'selected' : '' }}>Insurance</option>
                    <option value="other" {{ request('document_type') === 'other' ? 'selected' : '' }}>Other</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Document Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">File Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Upload Date</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($documents as $document)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $document->patient?->first_name . ' ' . $document->patient?->last_name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <x-badge variant="primary">{{ $document->document_type_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-primary">{{ $document->original_name }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $document->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.records.download', $document->id) }}" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Download">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <x-empty-state message="No documents found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($documents->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $documents->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection
