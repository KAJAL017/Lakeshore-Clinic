@extends('layouts.app')

@section('title', 'Specializations - Lakeshore Clinic')
@section('page-title', 'Specialization Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Specialization Management">
        <x-slot name="subtitle">Manage medical specializations</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-specialization">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Specialization
            </x-button>
        </x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search specializations..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Created</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($specializations as $spec)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-text-primary">{{ $spec->name }}</p>
                                        <p class="text-xs text-text-muted">{{ $spec->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted max-w-xs truncate">{{ $spec->description ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$spec->status" :label="$spec->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $spec->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewSpecialization({{ $spec->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button onclick="editSpecialization({{ $spec->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="deleteSpecialization({{ $spec->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <x-empty-state message="No specializations found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($specializations->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $specializations->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="create-specialization" title="Add New Specialization">
    <form id="create-spec-form" class="space-y-4">
        @csrf
        <x-input label="Specialization Name" name="name" placeholder="e.g., Cardiology" required />
        <x-textarea label="Description" name="description" placeholder="Brief description of this specialization" rows="3" />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-spec-btn" onclick="submitCreateSpecialization()">
            <span id="create-spec-text">Create</span>
            <svg id="create-spec-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="edit-specialization" title="Edit Specialization">
    <form id="edit-spec-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="spec_id" id="edit-spec-id">
        <x-input label="Specialization Name" name="name" id="edit-spec-name" required />
        <x-textarea label="Description" name="description" id="edit-spec-description" rows="3" />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="edit-spec-btn" onclick="submitEditSpecialization()">
            <span id="edit-spec-text">Update</span>
            <svg id="edit-spec-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="view-specialization" title="Specialization Details">
    <div id="spec-profile-content" class="space-y-4">
    </div>
</x-modal>

@push('scripts')
<script>
async function submitCreateSpecialization() {
    const form = document.getElementById('create-spec-form');
    const btn = document.getElementById('create-spec-btn');
    const btnText = document.getElementById('create-spec-text');
    const btnSpinner = document.getElementById('create-spec-spinner');

    btn.disabled = true;
    btnText.textContent = 'Creating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("admin.specializations.store") }}', {
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
                showToast(data.message || 'Failed to create specialization.', 'error');
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Create';
        btnSpinner.classList.add('hidden');
    }
}

async function editSpecialization(id) {
    try {
        const response = await fetch(`/admin/specializations/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const s = data.specialization;
            document.getElementById('edit-spec-id').value = s.id;
            document.getElementById('edit-spec-name').value = s.name;
            document.getElementById('edit-spec-description').value = s.description || '';
            openModal('modal-edit-specialization');
        }
    } catch (error) {
        showToast('Failed to load specialization data.', 'error');
    }
}

async function submitEditSpecialization() {
    const id = document.getElementById('edit-spec-id').value;
    const form = document.getElementById('edit-spec-form');
    const btn = document.getElementById('edit-spec-btn');
    const btnText = document.getElementById('edit-spec-text');
    const btnSpinner = document.getElementById('edit-spec-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const response = await fetch(`/admin/specializations/${id}`, {
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
                showToast(data.message || 'Failed to update specialization.', 'error');
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update';
        btnSpinner.classList.add('hidden');
    }
}

async function viewSpecialization(id) {
    try {
        const response = await fetch(`/admin/specializations/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const s = data.specialization;
            const content = `
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-xl bg-primary-500/10 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-text-primary">${s.name}</h3>
                        <p class="text-sm text-text-muted">${s.slug}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1 ${s.status === 'active' ? 'bg-health-100 text-health-800' : 'bg-gray-100 text-gray-800'}">${s.status}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-text-muted">Created:</span> <span class="text-text-primary">${new Date(s.created_at).toLocaleDateString()}</span></div>
                    <div><span class="text-text-muted">Updated:</span> <span class="text-text-primary">${new Date(s.updated_at).toLocaleDateString()}</span></div>
                </div>
                ${s.description ? `<div class="mt-4 text-sm"><span class="text-text-muted">Description:</span><p class="text-text-primary mt-1">${s.description}</p></div>` : ''}
                <div class="flex gap-2 mt-6">
                    ${s.status === 'active' ? `<button onclick="updateSpecStatus(${s.id}, 'inactive')" class="px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200">Deactivate</button>` : `<button onclick="updateSpecStatus(${s.id}, 'active')" class="px-3 py-1.5 text-sm bg-health-100 text-health-700 rounded-lg hover:bg-health-200">Activate</button>`}
                </div>
            `;
            document.getElementById('spec-profile-content').innerHTML = content;
            openModal('modal-view-specialization');
        }
    } catch (error) {
        showToast('Failed to load specialization details.', 'error');
    }
}

async function updateSpecStatus(id, status) {
    try {
        const response = await fetch(`/admin/specializations/${id}/status`, {
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

async function deleteSpecialization(id) {
    confirmAction('Are you sure you want to delete this specialization?', async () => {
        try {
            const response = await fetch(`/admin/specializations/${id}`, {
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
            } else {
                showToast(data.message || 'Failed to delete.', 'error');
            }
        } catch (error) {
            showToast('An error occurred.', 'error');
        }
    });
}
</script>
@endpush
@endsection
