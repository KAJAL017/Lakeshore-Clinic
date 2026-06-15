@extends('layouts.app')

@section('title', 'Clinic Settings - Lakeshore Clinic')
@section('page-title', 'Clinic Settings')

@section('content')
<div class="space-y-6">
    <x-page-header title="Clinic Settings">
        <x-slot name="subtitle">Configure your clinic information</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card variant="default">
            <div class="p-6">
                <x-page-header title="General Information" />
                <form id="settings-form" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-input label="Clinic Name" name="clinic_name" :value="$settings['clinic_name']" required />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input label="Clinic Email" name="clinic_email" type="email" :value="$settings['clinic_email']" required />
                        <x-input label="Clinic Phone" name="clinic_phone" :value="$settings['clinic_phone']" />
                    </div>
                    <x-textarea label="Clinic Address" name="clinic_address" :value="$settings['clinic_address']" rows="2" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-select label="Timezone" name="timezone" :value="$settings['timezone']" :options="['UTC' => 'UTC', 'America/New_York' => 'Eastern Time', 'America/Chicago' => 'Central Time', 'America/Denver' => 'Mountain Time', 'America/Los_Angeles' => 'Pacific Time']" />
                        <x-select label="Language" name="language" :value="$settings['language']" :options="['en' => 'English', 'es' => 'Spanish', 'fr' => 'French']" />
                    </div>
                    <div class="flex justify-end">
                        <x-button variant="primary" size="sm" id="save-settings-btn" type="submit">
                            <span id="save-settings-text">Save Settings</span>
                            <svg id="save-settings-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </x-button>
                    </div>
                </form>
            </div>
        </x-card>

        <div class="space-y-6">
            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Clinic Logo" />
                    <div class="flex items-center gap-6">
                        <div id="logo-preview" class="w-24 h-24 rounded-xl bg-surface border border-surface-border flex items-center justify-center overflow-hidden">
                            @if($settings['clinic_logo'])
                                <img src="{{ asset('uploads/branding/' . $settings['clinic_logo']) }}" alt="Logo" class="w-full h-full object-contain">
                            @else
                                <svg class="w-8 h-8 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-text-secondary mb-2">Upload your clinic logo. Recommended size: 200x200px. Max 2MB.</p>
                            <div class="flex items-center gap-2">
                                <input type="file" id="logo-input" accept="image/*" class="hidden">
                                <x-button variant="outline" size="sm" onclick="document.getElementById('logo-input').click()">Upload Logo</x-button>
                                @if($settings['clinic_logo'])
                                    <x-button variant="ghost" size="sm" id="remove-logo-btn" class="text-red-600 hover:bg-red-50">Remove</x-button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Clinic Favicon" />
                    <div class="flex items-center gap-6">
                        <div id="favicon-preview" class="w-16 h-16 rounded-lg bg-surface border border-surface-border flex items-center justify-center overflow-hidden">
                            @if($settings['clinic_favicon'])
                                <img src="{{ asset('uploads/branding/' . $settings['clinic_favicon']) }}" alt="Favicon" class="w-full h-full object-contain">
                            @else
                                <svg class="w-6 h-6 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-text-secondary mb-2">Upload your favicon. Recommended size: 32x32px. Max 512KB.</p>
                            <div class="flex items-center gap-2">
                                <input type="file" id="favicon-input" accept="image/*" class="hidden">
                                <x-button variant="outline" size="sm" onclick="document.getElementById('favicon-input').click()">Upload Favicon</x-button>
                                @if($settings['clinic_favicon'])
                                    <x-button variant="ghost" size="sm" id="remove-favicon-btn" class="text-red-600 hover:bg-red-50">Remove</x-button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <x-card variant="default">
        <div class="p-6">
            <x-page-header title="System Preferences" />
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-surface rounded-lg">
                    <h4 class="text-sm font-medium text-text-primary mb-1">Email Notifications</h4>
                    <p class="text-xs text-text-muted">Configure email settings</p>
                    <x-badge variant="default" class="mt-2">Coming Soon</x-badge>
                </div>
                <div class="p-4 bg-surface rounded-lg">
                    <h4 class="text-sm font-medium text-text-primary mb-1">SMS Notifications</h4>
                    <p class="text-xs text-text-muted">Configure SMS settings</p>
                    <x-badge variant="default" class="mt-2">Coming Soon</x-badge>
                </div>
                <div class="p-4 bg-surface rounded-lg">
                    <h4 class="text-sm font-medium text-text-primary mb-1">Integrations</h4>
                    <p class="text-xs text-text-muted">Third-party integrations</p>
                    <x-badge variant="default" class="mt-2">Coming Soon</x-badge>
                </div>
            </div>
        </div>
    </x-card>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('settings-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('save-settings-btn');
        const btnText = document.getElementById('save-settings-text');
        const btnSpinner = document.getElementById('save-settings-spinner');

        btn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("admin.settings.update") }}', {
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
            } else {
                showToast(data.message || 'Failed to save settings.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Save Settings';
            btnSpinner.classList.add('hidden');
        }
    });

    document.getElementById('logo-input').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('logo', file);

        try {
            const response = await fetch('{{ route("admin.settings.logo.upload") }}', {
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
                document.getElementById('logo-preview').innerHTML = `<img src="${data.logo_url}" alt="Logo" class="w-full h-full object-contain">`;
                location.reload();
            } else {
                showToast(data.message || 'Failed to upload logo.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        }
    });

    document.getElementById('favicon-input').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('favicon', file);

        try {
            const response = await fetch('{{ route("admin.settings.favicon.upload") }}', {
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
                document.getElementById('favicon-preview').innerHTML = `<img src="${data.favicon_url}" alt="Favicon" class="w-full h-full object-contain">`;
                location.reload();
            } else {
                showToast(data.message || 'Failed to upload favicon.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        }
    });

    const removeLogoBtn = document.getElementById('remove-logo-btn');
    if (removeLogoBtn) {
        removeLogoBtn.addEventListener('click', async function() {
            try {
                const response = await fetch('{{ route("admin.settings.logo.remove") }}', {
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
                    location.reload();
                }
            } catch (error) {
                showToast('An error occurred.', 'error');
            }
        });
    }

    const removeFaviconBtn = document.getElementById('remove-favicon-btn');
    if (removeFaviconBtn) {
        removeFaviconBtn.addEventListener('click', async function() {
            try {
                const response = await fetch('{{ route("admin.settings.favicon.remove") }}', {
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
                    location.reload();
                }
            } catch (error) {
                showToast('An error occurred.', 'error');
            }
        });
    }
});
</script>
@endpush
@endsection
