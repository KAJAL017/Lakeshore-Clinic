@extends('layouts.app')

@section('title', 'Users - Lakeshore Clinic')
@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="User Management">
        <x-slot name="subtitle">Manage users and their roles</x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @foreach($users as $user)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <x-avatar initials="{{ strtoupper(substr($user->name, 0, 2)) }}" size="sm" />
                                    <span class="text-sm font-medium text-text-primary">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($user->roles as $role)
                                        <x-badge variant="primary">{{ $role->name }}</x-badge>
                                    @empty
                                        <x-badge variant="default">No Role</x-badge>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="$user->status" :label="$user->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="editUserRole({{ $user->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Change Role">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </button>
                                    <button onclick="editUserStatus({{ $user->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Change Status">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</div>

<x-modal id="edit-user-role" title="Change User Role">
    <form id="edit-user-role-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" id="edit-role-user-id">
        <x-select label="Assign Role" name="role_id" id="edit-role-select" :options="$roles->pluck('name', 'id')->toArray()" required />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="save-role-btn" onclick="submitUserRole()">
            <span id="save-role-btn-text">Save</span>
            <svg id="save-role-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="edit-user-status" title="Change User Status">
    <form id="edit-user-status-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" id="edit-status-user-id">
        <x-select label="Status" name="status" id="edit-status-select" :options="['active' => 'Active', 'inactive' => 'Inactive', 'pending' => 'Pending', 'blocked' => 'Blocked', 'suspended' => 'Suspended']" required />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="save-status-btn" onclick="submitUserStatus()">
            <span id="save-status-btn-text">Save</span>
            <svg id="save-status-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function editUserRole(userId) {
    document.getElementById('edit-role-user-id').value = userId;
    openModal('modal-edit-user-role');
}

async function submitUserRole() {
    const userId = document.getElementById('edit-role-user-id').value;
    const roleId = document.getElementById('edit-role-select').value;
    const btn = document.getElementById('save-role-btn');
    const btnText = document.getElementById('save-role-btn-text');
    const btnSpinner = document.getElementById('save-role-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Saving...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('role_id', roleId);

        const response = await fetch(`/admin/users/${userId}/role`, {
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
        btnText.textContent = 'Save';
        btnSpinner.classList.add('hidden');
    }
}

async function editUserStatus(userId) {
    document.getElementById('edit-status-user-id').value = userId;
    openModal('modal-edit-user-status');
}

async function submitUserStatus() {
    const userId = document.getElementById('edit-status-user-id').value;
    const status = document.getElementById('edit-status-select').value;
    const btn = document.getElementById('save-status-btn');
    const btnText = document.getElementById('save-status-btn-text');
    const btnSpinner = document.getElementById('save-status-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Saving...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('status', status);

        const response = await fetch(`/admin/users/${userId}/status`, {
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
            showToast(data.message || 'Failed to update status.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Save';
        btnSpinner.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
