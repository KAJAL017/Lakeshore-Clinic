@extends('layouts.app')

@section('title', 'Time Slots - Lakeshore Clinic')
@section('page-title', 'Time Slot Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Time Slot Management">
        <x-slot name="subtitle">Manage doctor time slots</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by doctor name..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="doctor_id" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                    @endforeach
                </select>
                <select name="day" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Days</option>
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <option value="{{ $day }}" {{ request('day') === $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Day</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Duration</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Available</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($timeSlots as $slot)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $slot->doctor->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-primary capitalize">{{ $slot->day }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $slot->duration }} min</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $slot->is_available ? 'bg-health-100 text-health-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $slot->is_available ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$slot->status" :label="$slot->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="toggleSlot({{ $slot->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Toggle">
                                        <svg class="w-4 h-4 {{ $slot->is_available ? 'text-health-500' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    </button>
                                    <button onclick="deleteSlot({{ $slot->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <x-empty-state message="No time slots found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($timeSlots->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $timeSlots->links() }}
            </div>
        @endif
    </x-card>
</div>

@push('scripts')
<script>
async function toggleSlot(id) {
    try {
        const response = await fetch(`/admin/time-slots/${id}/toggle`, {
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
}

async function deleteSlot(id) {
    confirmAction('Are you sure you want to delete this time slot?', async () => {
        try {
            const response = await fetch(`/admin/time-slots/${id}`, {
                method: 'DELETE',
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
