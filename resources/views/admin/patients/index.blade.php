@extends('layouts.app')

@section('title', 'Patients - Lakeshore Clinic')
@section('page-title', 'Patient Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Patient Management">
        <x-slot name="subtitle">Manage your patients</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search patients by name, email, phone..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Gender</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Joined</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-500/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($patient->photo)
                                            <img src="{{ asset('uploads/patients/' . $patient->photo) }}" alt="{{ $patient->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-sm font-medium text-primary-600">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-text-primary">{{ $patient->name }}</p>
                                        <p class="text-xs text-text-muted">{{ $patient->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $patient->phone ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted capitalize">{{ $patient->gender ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$patient->status" :label="$patient->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $patient->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewPatient({{ $patient->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button onclick="editPatient({{ $patient->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No patients found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($patients->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $patients->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="edit-patient" title="Edit Patient" size="lg">
    <form id="edit-patient-form" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="patient_id" id="edit-patient-id">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="First Name" name="first_name" id="edit-patient-first" required />
            <x-input label="Last Name" name="last_name" id="edit-patient-last" required />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Email" name="email" id="edit-patient-email" type="email" required />
            <x-input label="Phone" name="phone" id="edit-patient-phone" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select label="Gender" name="gender" id="edit-patient-gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" placeholder="Select gender" />
            <x-input label="Date of Birth" name="date_of_birth" id="edit-patient-dob" type="date" />
        </div>
        <x-textarea label="Address" name="address" id="edit-patient-address" rows="2" />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Emergency Contact Name" name="emergency_contact_name" id="edit-patient-emergency-name" />
            <x-input label="Emergency Contact Phone" name="emergency_contact_phone" id="edit-patient-emergency-phone" />
        </div>
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Profile Photo</label>
            <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="edit-patient-btn" onclick="submitEditPatient()">
            <span id="edit-patient-text">Update Patient</span>
            <svg id="edit-patient-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="view-patient" title="Patient Profile" size="lg">
    <div id="patient-profile-content" class="space-y-4">
    </div>
</x-modal>

@push('scripts')
<script>
async function editPatient(id) {
    try {
        const response = await fetch(`/admin/patients/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.patient;
            document.getElementById('edit-patient-id').value = p.id;
            document.getElementById('edit-patient-first').value = p.first_name;
            document.getElementById('edit-patient-last').value = p.last_name;
            document.getElementById('edit-patient-email').value = p.email;
            document.getElementById('edit-patient-phone').value = p.phone || '';
            document.getElementById('edit-patient-gender').value = p.gender || '';
            document.getElementById('edit-patient-dob').value = p.date_of_birth ? p.date_of_birth.split('T')[0] : '';
            document.getElementById('edit-patient-address').value = p.address || '';
            document.getElementById('edit-patient-emergency-name').value = p.emergency_contact_name || '';
            document.getElementById('edit-patient-emergency-phone').value = p.emergency_contact_phone || '';
            openModal('modal-edit-patient');
        }
    } catch (error) {
        showToast('Failed to load patient data.', 'error');
    }
}

async function submitEditPatient() {
    const id = document.getElementById('edit-patient-id').value;
    const form = document.getElementById('edit-patient-form');
    const btn = document.getElementById('edit-patient-btn');
    const btnText = document.getElementById('edit-patient-text');
    const btnSpinner = document.getElementById('edit-patient-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const response = await fetch(`/admin/patients/${id}`, {
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
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    showToast(data.errors[field][0], 'error');
                });
            } else {
                showToast(data.message || 'Failed to update patient.', 'error');
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update Patient';
        btnSpinner.classList.add('hidden');
    }
}

async function viewPatient(id) {
    try {
        const response = await fetch(`/admin/patients/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.patient;
            const content = `
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-primary-500/20 flex items-center justify-center overflow-hidden">
                        ${p.photo ? `<img src="/uploads/patients/${p.photo}" class="w-full h-full object-cover">` : `<span class="text-xl font-bold text-primary-600">${p.first_name.substring(0, 1)}${p.last_name.substring(0, 1)}</span>`}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-text-primary">${p.first_name} ${p.last_name}</h3>
                        <p class="text-sm text-text-muted">${p.email}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1 ${p.status === 'active' ? 'bg-health-100 text-health-800' : 'bg-gray-100 text-gray-800'}">${p.status}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-text-muted">Phone:</span> <span class="text-text-primary">${p.phone || '-'}</span></div>
                    <div><span class="text-text-muted">Gender:</span> <span class="text-text-primary capitalize">${p.gender || '-'}</span></div>
                    <div><span class="text-text-muted">Date of Birth:</span> <span class="text-text-primary">${p.date_of_birth ? new Date(p.date_of_birth).toLocaleDateString() : '-'}</span></div>
                    <div><span class="text-text-muted">Joined:</span> <span class="text-text-primary">${new Date(p.created_at).toLocaleDateString()}</span></div>
                </div>
                ${p.address ? `<div class="mt-4 text-sm"><span class="text-text-muted">Address:</span> <span class="text-text-primary">${p.address}</span></div>` : ''}
                ${(p.emergency_contact_name || p.emergency_contact_phone) ? `
                <div class="mt-4 pt-4 border-t border-surface-border">
                    <p class="text-sm font-medium text-text-primary mb-2">Emergency Contact</p>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-text-muted">Name:</span> <span class="text-text-primary">${p.emergency_contact_name || '-'}</span></div>
                        <div><span class="text-text-muted">Phone:</span> <span class="text-text-primary">${p.emergency_contact_phone || '-'}</span></div>
                    </div>
                </div>
                ` : ''}
                <div class="flex gap-2 mt-6">
                    ${p.status === 'active' ? `<button onclick="updatePatientStatus(${p.id}, 'inactive')" class="px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200">Deactivate</button>` : `<button onclick="updatePatientStatus(${p.id}, 'active')" class="px-3 py-1.5 text-sm bg-health-100 text-health-700 rounded-lg hover:bg-health-200">Activate</button>`}
                    ${p.status !== 'blocked' ? `<button onclick="updatePatientStatus(${p.id}, 'blocked')" class="px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">Block</button>` : ''}
                </div>
            `;
            document.getElementById('patient-profile-content').innerHTML = content;
            openModal('modal-view-patient');
        }
    } catch (error) {
        showToast('Failed to load patient profile.', 'error');
    }
}

async function updatePatientStatus(id, status) {
    try {
        const response = await fetch(`/admin/patients/${id}/status`, {
            method: 'PUT',
            body: JSON.stringify({ status }),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
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
</script>
@endpush
@endsection
