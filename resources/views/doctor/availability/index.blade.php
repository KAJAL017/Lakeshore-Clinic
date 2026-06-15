@extends('layouts.doctor')

@section('title', 'My Availability - Lakeshore Clinic')
@section('page-title', 'My Availability')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Availability">
        <x-slot name="subtitle">Manage your working schedule</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-availability">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Schedule
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 md:grid-cols-7 gap-3">
        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
            @php
                $dayAvail = $availabilities->where('day', $day)->first();
            @endphp
            <x-card variant="{{ $dayAvail ? 'primary' : 'default' }}" class="p-4 text-center">
                <p class="text-sm font-medium text-text-primary capitalize mb-2">{{ $day }}</p>
                @if($dayAvail)
                    <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($dayAvail->start_time)->format('g:i A') }}</p>
                    <p class="text-xs text-text-muted">to</p>
                    <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($dayAvail->end_time)->format('g:i A') }}</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $dayAvail->is_available ? 'bg-health-100 text-health-700' : 'bg-red-100 text-red-700' }}">
                            {{ $dayAvail->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                @else
                    <p class="text-xs text-text-muted">Not set</p>
                @endif
            </x-card>
        @endforeach
    </div>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Day</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Available</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($availabilities as $avail)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-text-primary capitalize">{{ $avail->day }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ \Carbon\Carbon::parse($avail->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($avail->end_time)->format('h:i A') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $avail->is_available ? 'bg-health-100 text-health-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $avail->is_available ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$avail->status" :label="ucfirst($avail->status)" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="editAvailability({{ $avail->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="toggleAvailability({{ $avail->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Toggle">
                                        <svg class="w-4 h-4 {{ $avail->is_available ? 'text-health-500' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    </button>
                                    <button onclick="deleteAvailability({{ $avail->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <x-empty-state message="No availability schedules set. Add your working hours to get started." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>

<x-modal id="create-availability" title="Add Working Hours">
    <form id="create-avail-form" class="space-y-4">
        @csrf
        <x-select label="Day" name="day" :options="['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday']" required />
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Start Time" name="start_time" type="time" required />
            <x-input label="End Time" name="end_time" type="time" required />
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-avail-btn" onclick="submitCreateAvailability()">
            <span id="create-avail-text">Create</span>
            <svg id="create-avail-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="edit-availability" title="Edit Working Hours">
    <form id="edit-avail-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="avail_id" id="edit-avail-id">
        <x-select label="Day" name="day" id="edit-avail-day" :options="['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday']" required />
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Start Time" name="start_time" id="edit-avail-start" type="time" required />
            <x-input label="End Time" name="end_time" id="edit-avail-end" type="time" required />
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="edit-avail-btn" onclick="submitEditAvailability()">
            <span id="edit-avail-text">Update</span>
            <svg id="edit-avail-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function submitCreateAvailability() {
    const form = document.getElementById('create-avail-form');
    const btn = document.getElementById('create-avail-btn');
    const btnText = document.getElementById('create-avail-text');
    const btnSpinner = document.getElementById('create-avail-spinner');

    btn.disabled = true;
    btnText.textContent = 'Creating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("doctor.availability.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to create availability.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Create';
        btnSpinner.classList.add('hidden');
    }
}

async function editAvailability(id) {
    try {
        const response = await fetch(`/doctor/availability/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const a = data.availability;
            document.getElementById('edit-avail-id').value = a.id;
            document.getElementById('edit-avail-day').value = a.day;
            document.getElementById('edit-avail-start').value = a.start_time;
            document.getElementById('edit-avail-end').value = a.end_time;
            openModal('modal-edit-availability');
        }
    } catch (error) {
        showToast('Failed to load availability data.', 'error');
    }
}

async function submitEditAvailability() {
    const id = document.getElementById('edit-avail-id').value;
    const form = document.getElementById('edit-avail-form');
    const btn = document.getElementById('edit-avail-btn');
    const btnText = document.getElementById('edit-avail-text');
    const btnSpinner = document.getElementById('edit-avail-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const response = await fetch(`/doctor/availability/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to update availability.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update';
        btnSpinner.classList.add('hidden');
    }
}

async function toggleAvailability(id) {
    try {
        const response = await fetch(`/doctor/availability/${id}/toggle`, {
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

async function deleteAvailability(id) {
    confirmAction('Are you sure you want to delete this schedule?', async () => {
        try {
            const response = await fetch(`/doctor/availability/${id}`, {
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
