@extends('layouts.app')

@section('title', 'Doctors - Lakeshore Clinic')
@section('page-title', 'Doctor Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Doctor Management">
        <x-slot name="subtitle">Manage your doctors</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-doctor">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Doctor
            </x-button>
        </x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search doctors..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <select name="approval_status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Approval</option>
                    <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('approval_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Pending</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">License</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Approval</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($doctors as $doctor)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-500/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($doctor->photo)
                                            <img src="{{ asset('uploads/doctors/' . $doctor->photo) }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-sm font-medium text-primary-600">{{ strtoupper(substr($doctor->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-text-primary">{{ $doctor->name }}</p>
                                        <p class="text-xs text-text-muted">{{ $doctor->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $doctor->license_number ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $doctor->phone ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$doctor->status" :label="$doctor->status_label" />
                            </td>
                            <td class="px-4 py-3">
                                <x-badge variant="{{ $doctor->approval_status === 'approved' ? 'success' : ($doctor->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ $doctor->approval_status_label }}
                                </x-badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewDoctor({{ $doctor->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button onclick="editDoctor({{ $doctor->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="deleteDoctor({{ $doctor->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No doctors found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($doctors->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $doctors->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="create-doctor" title="Add New Doctor" size="lg">
    <form id="create-doctor-form" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Full Name" name="name" required />
            <x-input label="Email" name="email" type="email" required />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Phone" name="phone" />
            <x-input label="License Number" name="license_number" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Qualification" name="qualification" />
            <x-input label="Years of Experience" name="years_of_experience" type="number" min="0" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select label="Gender" name="gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" placeholder="Select gender" />
            <x-input label="Date of Birth" name="date_of_birth" type="date" />
        </div>
        <x-textarea label="Address" name="address" rows="2" />
        <x-textarea label="Biography" name="biography" rows="3" />
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Profile Photo</label>
            <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-doctor-btn" onclick="submitCreateDoctor()">
            <span id="create-doctor-text">Add Doctor</span>
            <svg id="create-doctor-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="edit-doctor" title="Edit Doctor" size="lg">
    <form id="edit-doctor-form" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="doctor_id" id="edit-doctor-id">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Full Name" name="name" id="edit-doctor-name" required />
            <x-input label="Email" name="email" id="edit-doctor-email" type="email" required />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Phone" name="phone" id="edit-doctor-phone" />
            <x-input label="License Number" name="license_number" id="edit-doctor-license" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Qualification" name="qualification" id="edit-doctor-qualification" />
            <x-input label="Years of Experience" name="years_of_experience" id="edit-doctor-exp" type="number" min="0" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select label="Gender" name="gender" id="edit-doctor-gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" placeholder="Select gender" />
            <x-input label="Date of Birth" name="date_of_birth" id="edit-dob" type="date" />
        </div>
        <x-textarea label="Address" name="address" id="edit-doctor-address" rows="2" />
        <x-textarea label="Biography" name="biography" id="edit-doctor-bio" rows="3" />
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Profile Photo</label>
            <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="edit-doctor-btn" onclick="submitEditDoctor()">
            <span id="edit-doctor-text">Update Doctor</span>
            <svg id="edit-doctor-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="view-doctor" title="Doctor Profile" size="lg">
    <div id="doctor-profile-content" class="space-y-4">
    </div>
</x-modal>

@push('scripts')
<script>
async function submitCreateDoctor() {
    const form = document.getElementById('create-doctor-form');
    const btn = document.getElementById('create-doctor-btn');
    const btnText = document.getElementById('create-doctor-text');
    const btnSpinner = document.getElementById('create-doctor-spinner');

    btn.disabled = true;
    btnText.textContent = 'Adding...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("admin.doctors.store") }}', {
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
                showToast(data.message || 'Failed to add doctor.', 'error');
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Add Doctor';
        btnSpinner.classList.add('hidden');
    }
}

async function editDoctor(id) {
    try {
        const response = await fetch(`/admin/doctors/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const d = data.doctor;
            document.getElementById('edit-doctor-id').value = d.id;
            document.getElementById('edit-doctor-name').value = d.name;
            document.getElementById('edit-doctor-email').value = d.email;
            document.getElementById('edit-doctor-phone').value = d.phone || '';
            document.getElementById('edit-doctor-license').value = d.license_number || '';
            document.getElementById('edit-doctor-qualification').value = d.qualification || '';
            document.getElementById('edit-doctor-exp').value = d.years_of_experience || '';
            document.getElementById('edit-doctor-gender').value = d.gender || '';
            document.getElementById('edit-dob').value = d.date_of_birth ? d.date_of_birth.split('T')[0] : '';
            document.getElementById('edit-doctor-address').value = d.address || '';
            document.getElementById('edit-doctor-bio').value = d.biography || '';
            openModal('modal-edit-doctor');
        }
    } catch (error) {
        showToast('Failed to load doctor data.', 'error');
    }
}

async function submitEditDoctor() {
    const id = document.getElementById('edit-doctor-id').value;
    const form = document.getElementById('edit-doctor-form');
    const btn = document.getElementById('edit-doctor-btn');
    const btnText = document.getElementById('edit-doctor-text');
    const btnSpinner = document.getElementById('edit-doctor-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const response = await fetch(`/admin/doctors/${id}`, {
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
                showToast(data.message || 'Failed to update doctor.', 'error');
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update Doctor';
        btnSpinner.classList.add('hidden');
    }
}

async function viewDoctor(id) {
    try {
        const response = await fetch(`/admin/doctors/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const d = data.doctor;
            const content = `
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-primary-500/20 flex items-center justify-center overflow-hidden">
                        ${d.photo ? `<img src="/uploads/doctors/${d.photo}" class="w-full h-full object-cover">` : `<span class="text-xl font-bold text-primary-600">${d.name.substring(0, 2).toUpperCase()}</span>`}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-text-primary">${d.name}</h3>
                        <p class="text-sm text-text-muted">${d.email}</p>
                        <div class="flex gap-2 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${d.status === 'active' ? 'bg-health-100 text-health-800' : 'bg-gray-100 text-gray-800'}">${d.status}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${d.approval_status === 'approved' ? 'bg-health-100 text-health-800' : (d.approval_status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800')}">${d.approval_status}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-text-muted">Phone:</span> <span class="text-text-primary">${d.phone || '-'}</span></div>
                    <div><span class="text-text-muted">License:</span> <span class="text-text-primary">${d.license_number || '-'}</span></div>
                    <div><span class="text-text-muted">Qualification:</span> <span class="text-text-primary">${d.qualification || '-'}</span></div>
                    <div><span class="text-text-muted">Experience:</span> <span class="text-text-primary">${d.years_of_experience || 0} years</span></div>
                    <div><span class="text-text-muted">Gender:</span> <span class="text-text-primary">${d.gender || '-'}</span></div>
                    <div><span class="text-text-muted">DOB:</span> <span class="text-text-primary">${d.date_of_birth ? new Date(d.date_of_birth).toLocaleDateString() : '-'}</span></div>
                </div>
                ${d.address ? `<div class="mt-4 text-sm"><span class="text-text-muted">Address:</span> <span class="text-text-primary">${d.address}</span></div>` : ''}
                ${d.biography ? `<div class="mt-4 text-sm"><span class="text-text-muted">Biography:</span> <span class="text-text-primary">${d.biography}</span></div>` : ''}
                <div class="flex gap-2 mt-6">
                    ${d.status === 'active' ? `<button onclick="updateDoctorStatus(${d.id}, 'inactive')" class="px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200">Deactivate</button>` : `<button onclick="updateDoctorStatus(${d.id}, 'active')" class="px-3 py-1.5 text-sm bg-health-100 text-health-700 rounded-lg hover:bg-health-200">Activate</button>`}
                    ${d.approval_status === 'approved' ? `<button onclick="updateDoctorApproval(${d.id}, 'rejected')" class="px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">Reject</button>` : `<button onclick="updateDoctorApproval(${d.id}, 'approved')" class="px-3 py-1.5 text-sm bg-health-100 text-health-700 rounded-lg hover:bg-health-200">Approve</button>`}
                </div>
            `;
            document.getElementById('doctor-profile-content').innerHTML = content;
            openModal('modal-view-doctor');
        }
    } catch (error) {
        showToast('Failed to load doctor profile.', 'error');
    }
}

async function updateDoctorStatus(id, status) {
    try {
        const response = await fetch(`/admin/doctors/${id}/status`, {
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

async function updateDoctorApproval(id, approval_status) {
    try {
        const response = await fetch(`/admin/doctors/${id}/approval`, {
            method: 'PUT',
            body: JSON.stringify({ approval_status }),
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

async function deleteDoctor(id) {
    confirmAction('Are you sure you want to delete this doctor?', async () => {
        try {
            const response = await fetch(`/admin/doctors/${id}`, {
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
