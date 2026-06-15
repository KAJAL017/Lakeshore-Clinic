@extends('layouts.app')

@section('title', 'Roles - Lakeshore Clinic')
@section('page-title', 'Role Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Role Management">
        <x-slot name="subtitle">Manage roles and their permissions</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-role">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Role
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
            <x-card variant="hover" class="p-6 overflow-hidden">
                <div class="flex items-start justify-between mb-4">
                    <div class="min-w-0 flex-1">
                        <h3 class="text-lg font-semibold text-text-primary">{{ $role->name }}</h3>
                        <p class="text-sm text-text-muted mt-0.5">{{ $role->description ?? 'No description' }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                        <button onclick="editRole({{ $role->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        @if(!in_array($role->slug, ['admin', 'doctor', 'patient']))
                            <button onclick="deleteRole({{ $role->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-2">Permissions ({{ $role->permissions->count() }})</p>
                    <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto">
                        @forelse($role->permissions as $permission)
                            <x-badge variant="primary">{{ $permission->name }}</x-badge>
                        @empty
                            <p class="text-sm text-text-muted">No permissions assigned</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-4 border-t border-surface-border">
                    <x-avatar initials="{{ strtoupper(substr($role->name, 0, 2)) }}" size="xs" color="primary" />
                    <span class="text-sm text-text-muted">{{ $role->users->count() }} users</span>
                </div>
            </x-card>
        @endforeach
    </div>
</div>

<x-modal id="create-role" title="Create New Role" size="lg">
    <form id="create-role-form" class="space-y-4">
        @csrf
        <x-input label="Role Name" name="name" placeholder="e.g., Nurse" required />
        <x-input label="Slug" name="slug" placeholder="e.g., nurse" hint="Lowercase, no spaces" required />
        <x-textarea label="Description" name="description" placeholder="Brief description of this role" />

        <div>
            <label class="block text-sm font-medium text-text-primary mb-2">Permissions</label>
            <div class="space-y-3 max-h-64 overflow-y-auto border border-surface-border rounded-lg p-4">
                @foreach($permissions ?? [] as $group => $perms)
                    <div>
                        <p class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">{{ $group }}</p>
                        <div class="space-y-2">
                            @foreach($perms as $permission)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="text-sm text-text-primary">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-role-btn" onclick="submitCreateRole()">
            <span id="create-role-btn-text">Create Role</span>
            <svg id="create-role-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="edit-role" title="Edit Role" size="lg">
    <form id="edit-role-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="role_id" id="edit-role-id">
        <x-input label="Role Name" name="name" id="edit-role-name" required />
        <x-input label="Slug" name="slug" id="edit-role-slug" required />
        <x-textarea label="Description" name="description" id="edit-role-description" />

        <div>
            <label class="block text-sm font-medium text-text-primary mb-2">Permissions</label>
            <div class="space-y-3 max-h-64 overflow-y-auto border border-surface-border rounded-lg p-4" id="edit-role-permissions">
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="edit-role-btn" onclick="submitEditRole()">
            <span id="edit-role-btn-text">Update Role</span>
            <svg id="edit-role-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
const allPermissions = @json($permissions ?? []);

async function submitCreateRole() {
    const form = document.getElementById('create-role-form');
    const btn = document.getElementById('create-role-btn');
    const btnText = document.getElementById('create-role-btn-text');
    const btnSpinner = document.getElementById('create-role-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Creating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("admin.roles.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to create role.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Create Role';
        btnSpinner.classList.add('hidden');
    }
}

async function editRole(roleId) {
    try {
        const response = await fetch(`/admin/roles/${roleId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('edit-role-id').value = data.role.id;
            document.getElementById('edit-role-name').value = data.role.name;
            document.getElementById('edit-role-slug').value = data.role.slug;
            document.getElementById('edit-role-description').value = data.role.description || '';

            const permissionsContainer = document.getElementById('edit-role-permissions');
            let html = '';
            const rolePermissionIds = data.role.permissions.map(p => p.id);

            Object.keys(allPermissions).forEach(group => {
                html += `<div><p class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">${group}</p><div class="space-y-2">`;
                allPermissions[group].forEach(permission => {
                    const checked = rolePermissionIds.includes(permission.id) ? 'checked' : '';
                    html += `<label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="permissions[]" value="${permission.id}" ${checked} class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"><span class="text-sm text-text-primary">${permission.name}</span></label>`;
                });
                html += '</div></div>';
            });

            permissionsContainer.innerHTML = html;
            openModal('modal-edit-role');
        }
    } catch (error) {
        showToast('Failed to load role data.', 'error');
    }
}

async function submitEditRole() {
    const form = document.getElementById('edit-role-form');
    const roleId = document.getElementById('edit-role-id').value;
    const btn = document.getElementById('edit-role-btn');
    const btnText = document.getElementById('edit-role-btn-text');
    const btnSpinner = document.getElementById('edit-role-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        const response = await fetch(`/admin/roles/${roleId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to update role.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update Role';
        btnSpinner.classList.add('hidden');
    }
}

async function deleteRole(roleId) {
    confirmAction('Are you sure you want to delete this role?', async () => {
        try {
            const response = await fetch(`/admin/roles/${roleId}`, {
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
                showToast(data.message || 'Failed to delete role.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        }
    });
}
</script>
@endpush
@endsection
