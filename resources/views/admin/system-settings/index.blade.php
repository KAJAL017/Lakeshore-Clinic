@extends('layouts.app')

@section('title', 'System Settings - Lakeshore Clinic')
@section('page-title', 'System Settings')

@section('content')
<div class="space-y-6">
    <x-page-header title="System Settings">
        <x-slot name="subtitle">Configure system-wide settings</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1">
            <x-card variant="default">
                <div class="p-4">
                    <nav class="space-y-1">
                        <button onclick="showSection('general')" class="settings-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-50 text-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            General
                        </button>
                        <button onclick="showSection('appointment')" class="settings-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-text-secondary hover:bg-surface transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Appointments
                        </button>
                        <button onclick="showSection('telemedicine')" class="settings-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-text-secondary hover:bg-surface transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            Telemedicine
                        </button>
                        <button onclick="showSection('payment')" class="settings-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-text-secondary hover:bg-surface transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Payments
                        </button>
                        <button onclick="showSection('notification')" class="settings-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-text-secondary hover:bg-surface transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Notifications
                        </button>
                        <button onclick="showSection('doctor')" class="settings-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-text-secondary hover:bg-surface transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Doctors
                        </button>
                    </nav>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-3">
            <div id="section-general" class="settings-section">
                <x-card variant="default">
                    <div class="p-6">
                        <x-page-header title="General Settings" />
                        <form id="settings-form-general" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group" value="general">
                            <x-input label="System Name" name="settings[system_name]" :value="$settings['general']['system_name'] ?? 'Lakeshore Clinic'" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-input label="System Email" name="settings[system_email]" type="email" :value="$settings['general']['system_email'] ?? 'admin@lakeshore.com'" />
                                <x-input label="System Phone" name="settings[system_phone]" :value="$settings['general']['system_phone'] ?? '+1 (555) 123-4567'" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-select label="Timezone" name="settings[timezone]" :value="$settings['general']['timezone'] ?? 'UTC'" :options="['UTC' => 'UTC', 'America/New_York' => 'Eastern Time', 'America/Chicago' => 'Central Time', 'America/Denver' => 'Mountain Time', 'America/Los_Angeles' => 'Pacific Time']" />
                                <x-select label="Default Language" name="settings[language]" :value="$settings['general']['language'] ?? 'en'" :options="['en' => 'English', 'es' => 'Spanish', 'fr' => 'French']" />
                            </div>
                            <x-select label="Currency" name="settings[currency]" :value="$settings['general']['currency'] ?? 'USD'" :options="['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'CAD' => 'CAD (C$)']" />
                            <div class="flex justify-end">
                                <x-button variant="primary" size="sm" type="submit">
                                    <span id="save-general-text">Save Settings</span>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>

            <div id="section-appointment" class="settings-section hidden">
                <x-card variant="default">
                    <div class="p-6">
                        <x-page-header title="Appointment Settings" />
                        <form id="settings-form-appointment" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group" value="appointment">
                            <x-select label="Default Appointment Status" name="settings[default_status]" :value="$settings['appointment']['default_status'] ?? 'pending'" :options="['pending' => 'Pending', 'approved' => 'Approved']" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-input label="Max Cancellation Hours" name="settings[max_cancellation_hours]" type="number" :value="$settings['appointment']['max_cancellation_hours'] ?? '24'" />
                                <x-input label="Max Reschedule Hours" name="settings[max_reschedule_hours]" type="number" :value="$settings['appointment']['max_reschedule_hours'] ?? '48'" />
                            </div>
                            <div class="flex justify-end">
                                <x-button variant="primary" size="sm" type="submit">
                                    <span id="save-appointment-text">Save Settings</span>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>

            <div id="section-telemedicine" class="settings-section hidden">
                <x-card variant="default">
                    <div class="p-6">
                        <x-page-header title="Telemedicine Settings" />
                        <form id="settings-form-telemedicine" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group" value="telemedicine">
                            <x-input label="Teams Tenant ID" name="settings[teams_tenant_id]" :value="$settings['telemedicine']['teams_tenant_id'] ?? ''" placeholder="Microsoft Teams Tenant ID" />
                            <x-input label="Meeting Duration (minutes)" name="settings[meeting_duration]" type="number" :value="$settings['telemedicine']['meeting_duration'] ?? '30'" />
                            <div class="p-4 bg-surface rounded-lg">
                                <p class="text-sm text-text-muted">Additional telemedicine settings will be available when Microsoft Teams integration is fully implemented.</p>
                            </div>
                            <div class="flex justify-end">
                                <x-button variant="primary" size="sm" type="submit">
                                    <span id="save-telemedicine-text">Save Settings</span>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>

            <div id="section-payment" class="settings-section hidden">
                <x-card variant="default">
                    <div class="p-6">
                        <x-page-header title="Payment Settings" />
                        <form id="settings-form-payment" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group" value="payment">
                            <x-input label="Stripe Publishable Key" name="settings[stripe_publishable_key]" :value="$settings['payment']['stripe_publishable_key'] ?? ''" placeholder="pk_test_..." />
                            <x-input label="Stripe Secret Key" name="settings[stripe_secret_key]" :value="$settings['payment']['stripe_secret_key'] ?? ''" placeholder="sk_test_..." type="password" />
                            <div class="p-4 bg-surface rounded-lg">
                                <p class="text-sm text-text-muted">Additional payment settings will be available when Stripe integration is fully implemented.</p>
                            </div>
                            <div class="flex justify-end">
                                <x-button variant="primary" size="sm" type="submit">
                                    <span id="save-payment-text">Save Settings</span>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>

            <div id="section-notification" class="settings-section hidden">
                <x-card variant="default">
                    <div class="p-6">
                        <x-page-header title="Notification Settings" />
                        <form id="settings-form-notification" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group" value="notification">
                            <x-input label="SMTP Host" name="settings[smtp_host]" :value="$settings['notification']['smtp_host'] ?? ''" placeholder="smtp.gmail.com" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-input label="SMTP Port" name="settings[smtp_port]" type="number" :value="$settings['notification']['smtp_port'] ?? '587'" />
                                <x-input label="SMTP Username" name="settings[smtp_username]" :value="$settings['notification']['smtp_username'] ?? ''" />
                            </div>
                            <x-input label="SMTP Password" name="settings[smtp_password]" type="password" :value="$settings['notification']['smtp_password'] ?? ''" />
                            <div class="p-4 bg-surface rounded-lg">
                                <p class="text-sm text-text-muted">Additional notification settings will be available when email/SMS integration is fully implemented.</p>
                            </div>
                            <div class="flex justify-end">
                                <x-button variant="primary" size="sm" type="submit">
                                    <span id="save-notification-text">Save Settings</span>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>

            <div id="section-doctor" class="settings-section hidden">
                <x-card variant="default">
                    <div class="p-6">
                        <x-page-header title="Doctor Settings" />
                        <form id="settings-form-doctor" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="group" value="doctor">
                            <x-select label="Auto Approve Doctors" name="settings[auto_approve]" :value="$settings['doctor']['auto_approve'] ?? 'no'" :options="['yes' => 'Yes', 'no' => 'No']" />
                            <x-select label="Require License Verification" name="settings[require_license]" :value="$settings['doctor']['require_license'] ?? 'yes'" :options="['yes' => 'Yes', 'no' => 'No']" />
                            <div class="p-4 bg-surface rounded-lg">
                                <p class="text-sm text-text-muted">Additional doctor settings will be available when verification features are fully implemented.</p>
                            </div>
                            <div class="flex justify-end">
                                <x-button variant="primary" size="sm" type="submit">
                                    <span id="save-doctor-text">Save Settings</span>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showSection(section) {
    document.querySelectorAll('.settings-section').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.settings-tab').forEach(el => {
        el.classList.remove('bg-primary-50', 'text-primary-600');
        el.classList.add('text-text-secondary');
    });

    document.getElementById(`section-${section}`).classList.remove('hidden');
    event.currentTarget.classList.add('bg-primary-50', 'text-primary-600');
    event.currentTarget.classList.remove('text-text-secondary');
}

document.querySelectorAll('[id^="settings-form-"]').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const group = formData.get('group');

        try {
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
        }
    });
});
</script>
@endpush
@endsection
