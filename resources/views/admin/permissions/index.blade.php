@extends('layouts.app')

@section('title', 'Permissions - Lakeshore Clinic')
@section('page-title', 'Permission Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Permission Management">
        <x-slot name="subtitle">Manage system permissions</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-permission">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Permission
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="space-y-6">
        @foreach($permissions as $group => $perms)
            <x-card variant="default" class="p-6">
                <h3 class="text-lg font-semibold text-text-primary mb-4">{{ $group }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-surface-border">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Slug</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Roles</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-border">
                            @foreach($perms as $permission)
                                <tr class="hover:bg-surface transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-text-primary">{{ $permission->name }}</td>
                                    <td class="px-4 py-3 text-sm text-text-muted font-mono">{{ $permission->slug }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($permission->roles as $role)
                                                <x-badge variant="primary">{{ $role->name }}</x-badge>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button onclick="deletePermission({{ $permission->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 inline-flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @endforeach
    </div>

    <x-card variant="default" class="p-6">
        <h3 class="text-lg font-semibold text-text-primary mb-4">Assign Permissions to Role</h3>
        <form id="assign-permissions-form" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Select Role" name="role_id" :options="$roles->pluck('name', 'id')->toArray()" placeholder="Choose a role" required />
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto border border-surface-border rounded-lg p-4">
                @foreach($permissions as $group => $perms)
                    <div>
                        <p class="text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">{{ $group }}</p>
                        <div class="space-y-2">
                            @foreach($perms as $permission)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="text-sm text-text-primary">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end">
                <x-button variant="primary" size="sm" id="assign-btn" onclick="submitAssignPermissions()">
                    <span id="assign-btn-text">Assign Permissions</span>
                    <svg id="assign-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </x-button>
            </div>
        </form>
    </x-card>
</div>

<x-modal id="create-permission" title="Create New Permission">
    <form id="create-permission-form" class="space-y-4">
        @csrf
        <x-input label="Permission Name" name="name" placeholder="e.g., View Reports" required />
        <x-input label="Slug" name="slug" placeholder="e.g., reports.view" hint="Lowercase with dots" required />
        <x-input label="Group" name="group" placeholder="e.g., Reports" required />
        <x-textarea label="Description" name="description" placeholder="Brief description" />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-perm-btn" onclick="submitCreatePermission()">
            <span id="create-perm-btn-text">Create</span>
            <svg id="create-perm-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function submitCreatePermission() {
    const form = document.getElementById('create-permission-form');
    const btn = document.getElementById('create-perm-btn');
    const btnText = document.getElementById('create-perm-btn-text');
    const btnSpinner = document.getElementById('create-perm-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Creating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("admin.permissions.store") }}', {
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
            showToast(data.message || 'Failed to create permission.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Create';
        btnSpinner.classList.add('hidden');
    }
}

async function submitAssignPermissions() {
    const form = document.getElementById('assign-permissions-form');
    const btn = document.getElementById('assign-btn');
    const btnText = document.getElementById('assign-btn-text');
    const btnSpinner = document.getElementById('assign-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Assigning...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("admin.permissions.assign-role") }}', {
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
            showToast(data.message || 'Failed to assign permissions.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Assign Permissions';
        btnSpinner.classList.add('hidden');
    }
}

async function deletePermission(permissionId) {
    confirmAction('Are you sure you want to delete this permission?', async () => {
        try {
            const response = await fetch(`/admin/permissions/${permissionId}`, {
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
                showToast(data.message || 'Failed to delete permission.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        }
    });
}
</script>
@endpush
@endsection
