@extends('layouts.doctor')

@section('title', 'My Availability - Lakeshore Clinic')
@section('page-title', 'My Availability')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-400">Manage your working schedule and availability</p>
        <button onclick="openModal('modal-create-availability')" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-colors" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Schedule
        </button>
    </div>

    {{-- Weekly Overview --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3">
        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
            @php $dayAvail = $availabilities->where('day', $day)->first(); @endphp
            <div class="rounded-2xl p-4 text-center border transition-all {{ $dayAvail ? 'bg-white border-blue-100 shadow-sm' : 'bg-gray-50 border-gray-100' }}">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ substr($day, 0, 3) }}</p>
                @if($dayAvail)
                    <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($dayAvail->start_time)->format('g:i A') }}</p>
                    <p class="text-xs text-gray-400 my-0.5">to</p>
                    <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($dayAvail->end_time)->format('g:i A') }}</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold {{ $dayAvail->is_available ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                            {{ $dayAvail->is_available ? 'Active' : 'Off' }}
                        </span>
                    </div>
                @else
                    <p class="text-xs text-gray-300 mt-3">Not set</p>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Schedules Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Day</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Time</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Available</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($availabilities as $avail)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4 text-sm font-semibold text-gray-900 capitalize">{{ $avail->day }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($avail->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($avail->end_time)->format('h:i A') }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $avail->is_available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    {{ $avail->is_available ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $statusStyles = match($avail->status) {
                                        'active' => 'bg-green-50 text-green-700',
                                        'inactive' => 'bg-gray-50 text-gray-700',
                                        default => 'bg-gray-50 text-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusStyles }}">{{ ucfirst($avail->status) }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="editAvailability({{ $avail->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="toggleAvailability({{ $avail->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Toggle">
                                        <svg class="w-4 h-4 {{ $avail->is_available ? 'text-green-500' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    </button>
                                    <button onclick="deleteAvailability({{ $avail->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                        <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">No schedules</p>
                                    <p class="text-xs text-gray-400 mt-1">Add your working hours to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal id="create-availability" title="Add Working Hours">
    <form id="create-avail-form" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Day</label>
            <select name="day" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Time</label>
                <input type="time" name="start_time" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">End Time</label>
                <input type="time" name="end_time" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button onclick="closeModal('modal-create-availability')" class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Cancel</button>
        <button onclick="submitCreateAvailability()" id="create-avail-btn" class="px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-colors" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <span id="create-avail-text">Create</span>
            <svg id="create-avail-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </button>
    </x-slot>
</x-modal>

<x-modal id="edit-availability" title="Edit Working Hours">
    <form id="edit-avail-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="avail_id" id="edit-avail-id">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Day</label>
            <select name="day" id="edit-avail-day" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Time</label>
                <input type="time" name="start_time" id="edit-avail-start" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">End Time</label>
                <input type="time" name="end_time" id="edit-avail-end" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button onclick="closeModal('modal-edit-availability')" class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Cancel</button>
        <button onclick="submitEditAvailability()" id="edit-avail-btn" class="px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-colors" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <span id="edit-avail-text">Update</span>
            <svg id="edit-avail-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </button>
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
