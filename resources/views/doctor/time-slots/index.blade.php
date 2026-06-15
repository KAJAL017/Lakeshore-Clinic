@extends('layouts.doctor')

@section('title', 'My Time Slots - Lakeshore Clinic')
@section('page-title', 'My Time Slots')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Time Slots">
        <x-slot name="subtitle">Manage your appointment slots</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-slot">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Time Slot
            </x-button>
        </x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
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
                            <td class="px-4 py-3 text-sm font-medium text-text-primary capitalize">{{ $slot->day }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $slot->duration }} min</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $slot->is_available ? 'bg-health-100 text-health-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $slot->is_available ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$slot->status" :label="ucfirst($slot->status)" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="editSlot({{ $slot->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
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
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No time slots set. Add your available time slots." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>

<x-modal id="create-slot" title="Add Time Slot">
    <form id="create-slot-form" class="space-y-4">
        @csrf
        <x-select label="Day" name="day" :options="['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday']" required />
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Start Time" name="start_time" type="time" required />
            <x-input label="End Time" name="end_time" type="time" required />
        </div>
        <x-select label="Duration (minutes)" name="duration" :options="[15 => '15 Minutes', 20 => '20 Minutes', 30 => '30 Minutes', 45 => '45 Minutes', 60 => '60 Minutes']" required />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-slot-btn" onclick="submitCreateSlot()">
            <span id="create-slot-text">Create</span>
            <svg id="create-slot-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="edit-slot" title="Edit Time Slot">
    <form id="edit-slot-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="slot_id" id="edit-slot-id">
        <x-select label="Day" name="day" id="edit-slot-day" :options="['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday']" required />
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Start Time" name="start_time" id="edit-slot-start" type="time" required />
            <x-input label="End Time" name="end_time" id="edit-slot-end" type="time" required />
        </div>
        <x-select label="Duration (minutes)" name="duration" id="edit-slot-duration" :options="[15 => '15 Minutes', 20 => '20 Minutes', 30 => '30 Minutes', 45 => '45 Minutes', 60 => '60 Minutes']" required />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="edit-slot-btn" onclick="submitEditSlot()">
            <span id="edit-slot-text">Update</span>
            <svg id="edit-slot-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function submitCreateSlot() {
    const form = document.getElementById('create-slot-form');
    const btn = document.getElementById('create-slot-btn');
    const btnText = document.getElementById('create-slot-text');
    const btnSpinner = document.getElementById('create-slot-spinner');

    btn.disabled = true;
    btnText.textContent = 'Creating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("doctor.time-slots.store") }}', {
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
            showToast(data.message || 'Failed to create time slot.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Create';
        btnSpinner.classList.add('hidden');
    }
}

async function editSlot(id) {
    try {
        const response = await fetch(`/doctor/time-slots/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const s = data.timeSlot;
            document.getElementById('edit-slot-id').value = s.id;
            document.getElementById('edit-slot-day').value = s.day;
            document.getElementById('edit-slot-start').value = s.start_time;
            document.getElementById('edit-slot-end').value = s.end_time;
            document.getElementById('edit-slot-duration').value = s.duration;
            openModal('modal-edit-slot');
        }
    } catch (error) {
        showToast('Failed to load time slot data.', 'error');
    }
}

async function submitEditSlot() {
    const id = document.getElementById('edit-slot-id').value;
    const form = document.getElementById('edit-slot-form');
    const btn = document.getElementById('edit-slot-btn');
    const btnText = document.getElementById('edit-slot-text');
    const btnSpinner = document.getElementById('edit-slot-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const response = await fetch(`/doctor/time-slots/${id}`, {
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
            showToast(data.message || 'Failed to update time slot.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update';
        btnSpinner.classList.add('hidden');
    }
}

async function toggleSlot(id) {
    try {
        const response = await fetch(`/doctor/time-slots/${id}/toggle`, {
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
            const response = await fetch(`/doctor/time-slots/${id}`, {
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
