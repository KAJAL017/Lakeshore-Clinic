@extends('layouts.doctor-mobile')

@section('title', 'Time Slots')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    {{-- Header --}}
    <div class="sticky top-0 z-30 bg-white border-b border-gray-100 px-4 py-3">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">Time Slots</h1>
            <button onclick="openModal('add')" class="inline-flex items-center gap-1.5 bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium active:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add
            </button>
        </div>
    </div>

    {{-- Summary Bar --}}
    @if($timeSlots->count() > 0)
        <div class="px-4 pt-4 pb-2">
            <div class="flex items-center gap-3 text-xs font-medium text-gray-500">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    {{ $timeSlots->count() }} {{ Str::plural('slot', $timeSlots->count()) }}
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    {{ $timeSlots->where('is_available', true)->count() }} Active
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                    {{ $timeSlots->where('is_available', false)->count() }} Inactive
                </span>
            </div>
        </div>
    @endif

    {{-- Time Slots List --}}
    <div class="px-4 py-3" id="slots-list">
        @forelse($timeSlots as $slot)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-3 overflow-hidden" data-id="{{ $slot->id }}">
                <div class="p-4">
                    {{-- Top Row: Day + Toggle --}}
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-gray-900 capitalize">{{ $slot->day }}</p>
                                <p class="text-xs text-gray-400 font-medium mt-0.5">{{ $slot->duration }} min</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   class="sr-only peer"
                                   data-id="{{ $slot->id }}"
                                   {{ $slot->is_available ? 'checked' : '' }}
                                   onchange="toggleSlot({{ $slot->id }}, this.checked)">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    {{-- Time Display --}}
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-lg">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-lg">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</span>
                        </div>
                        <span class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $slot->is_available ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $slot->is_available ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('edit', {{ $slot->id }}, '{{ $slot->day }}', '{{ $slot->start_time }}', '{{ $slot->end_time }}', {{ $slot->duration }})"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 px-3 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <button onclick="deleteSlot({{ $slot->id }})"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 px-3 bg-red-50 hover:bg-red-100 rounded-lg text-sm font-medium text-red-600 transition-colors active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No Time Slots</h3>
                <p class="text-sm text-gray-500 mb-6 max-w-xs">Add your available time slots so patients can book appointments with you.</p>
                <button onclick="openModal('add')" class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium active:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Time Slot
                </button>
            </div>
        @endforelse
    </div>
</div>

{{-- Bottom Sheet Modal --}}
<div id="bottomSheet" class="fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div id="backdrop" class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeModal()"></div>

    {{-- Sheet --}}
    <div id="sheetContent" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-300 ease-out max-h-[85vh] overflow-hidden">
        {{-- Handle --}}
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
        </div>

        {{-- Header --}}
        <div class="px-5 pb-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 id="modalTitle" class="text-lg font-semibold text-gray-900">Add Time Slot</h2>
                <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Form --}}
        <form id="slotForm" class="px-5 py-5 overflow-y-auto max-h-[calc(85vh-120px)]">
            @csrf
            <input type="hidden" id="formMethod" value="POST">
            <input type="hidden" id="slotId" value="">

            {{-- Day of Week --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Day</label>
                <select id="dayOfWeek" name="day" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none">
                    <option value="">Select Day</option>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                    <option value="sunday">Sunday</option>
                </select>
                <p class="text-xs text-red-500 mt-1 hidden" id="dayError"></p>
            </div>

            {{-- Start Time --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                <input type="time" id="startTime" name="start_time" required
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                <p class="text-xs text-red-500 mt-1 hidden" id="startError"></p>
            </div>

            {{-- End Time --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                <input type="time" id="endTime" name="end_time" required
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                <p class="text-xs text-red-500 mt-1 hidden" id="endError"></p>
            </div>

            {{-- Duration --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                <select id="duration" name="duration" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none">
                    <option value="">Select Duration</option>
                    <option value="15">15 Minutes</option>
                    <option value="20">20 Minutes</option>
                    <option value="30">30 Minutes</option>
                    <option value="45">45 Minutes</option>
                    <option value="60">60 Minutes</option>
                </select>
                <p class="text-xs text-red-500 mt-1 hidden" id="durationError"></p>
            </div>

            {{-- Submit Button --}}
            <button type="submit" id="submitBtn"
                    class="w-full py-3.5 bg-blue-600 text-white rounded-xl font-medium text-sm hover:bg-blue-700 active:bg-blue-800 transition-colors flex items-center justify-center gap-2">
                <span id="btnText">Save Time Slot</span>
                <svg id="btnSpinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

{{-- Toast Container --}}
<div id="toastContainer" class="fixed top-4 left-4 right-4 z-[100] space-y-2"></div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentMode = 'add';
    let currentId = null;

    function openModal(mode, id = null, day = '', startTime = '', endTime = '', duration = '') {
        currentMode = mode;
        currentId = id;
        const sheet = document.getElementById('bottomSheet');
        const backdrop = document.getElementById('backdrop');
        const content = document.getElementById('sheetContent');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('slotForm');

        form.reset();
        clearErrors();

        if (mode === 'edit') {
            title.textContent = 'Edit Time Slot';
            document.getElementById('slotId').value = id;
            document.getElementById('dayOfWeek').value = day;
            document.getElementById('startTime').value = startTime.substring(0, 5);
            document.getElementById('endTime').value = endTime.substring(0, 5);
            document.getElementById('duration').value = duration;
            document.getElementById('btnText').textContent = 'Update Time Slot';
        } else {
            title.textContent = 'Add Time Slot';
            document.getElementById('slotId').value = '';
            document.getElementById('btnText').textContent = 'Save Time Slot';
        }

        sheet.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            content.classList.remove('translate-y-full');
        });
    }

    function closeModal() {
        const backdrop = document.getElementById('backdrop');
        const content = document.getElementById('sheetContent');
        const sheet = document.getElementById('bottomSheet');

        backdrop.classList.add('opacity-0');
        content.classList.add('translate-y-full');
        setTimeout(() => sheet.classList.add('hidden'), 300);
    }

    document.getElementById('slotForm').addEventListener('submit', function(e) {
        e.preventDefault();
        clearErrors();

        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        btn.disabled = true;
        btnText.textContent = currentMode === 'edit' ? 'Updating...' : 'Saving...';
        btnSpinner.classList.remove('hidden');

        const id = document.getElementById('slotId').value;
        const url = currentMode === 'edit'
            ? `/doctor/time-slots/${id}`
            : '/doctor/time-slots';

        const formData = new FormData(this);
        if (currentMode === 'edit') {
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const errorEl = document.getElementById(key + 'Error');
                    if (errorEl) {
                        errorEl.textContent = data.errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                });
                showToast('Please fix the errors below', 'error');
                return;
            }

            if (data.success) {
                showToast(data.message || 'Time slot saved successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(err => {
            showToast('Something went wrong. Please try again.', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btnText.textContent = currentMode === 'edit' ? 'Update Time Slot' : 'Save Time Slot';
            btnSpinner.classList.add('hidden');
        });
    });

    function toggleSlot(id, isAvailable) {
        fetch(`/doctor/time-slots/${id}/toggle`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ is_available: isAvailable })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Status updated', 'success');
                const card = document.querySelector(`[data-id="${id}"]`);
                if (card) {
                    const badge = card.querySelector('.rounded-full.font-semibold');
                    if (badge) {
                        badge.className = `px-2 py-0.5 text-[11px] font-semibold rounded-full ${isAvailable ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'}`;
                        badge.textContent = isAvailable ? 'Active' : 'Inactive';
                    }
                }
            }
        })
        .catch(() => {
            showToast('Failed to update status', 'error');
            location.reload();
        });
    }

    function deleteSlot(id) {
        if (!confirm('Are you sure you want to delete this time slot?')) return;

        fetch(`/doctor/time-slots/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Time slot deleted', 'success');
                const card = document.querySelector(`[data-id="${id}"]`);
                if (card) {
                    card.style.transition = 'opacity 0.3s, transform 0.3s';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        card.remove();
                        if (!document.querySelector('#slots-list > div')) {
                            location.reload();
                        }
                    }, 300);
                }
            }
        })
        .catch(() => {
            showToast('Failed to delete time slot', 'error');
        });
    }

    function clearErrors() {
        document.querySelectorAll('[id$="Error"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        const icon = type === 'success'
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
            : type === 'error'
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';

        toast.className = `${bgColor} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 text-sm font-medium transform transition-all duration-300 opacity-0 -translate-y-2`;
        toast.innerHTML = `
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icon}
            </svg>
            <span class="flex-1">${message}</span>
        `;
        container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', '-translate-y-2');
            toast.classList.add('opacity-100', 'translate-y-0');
        });

        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>
@endsection
