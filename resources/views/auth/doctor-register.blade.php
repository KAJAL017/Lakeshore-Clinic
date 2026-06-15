<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctor Registration - Lakeshore Clinic</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-surface">
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <div class="min-h-full flex">
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#1e3a5f] via-[#2d5a87] to-[#1e3a5f] relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>
            <div class="relative z-10 flex flex-col items-center justify-center w-full p-12">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-8">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-4">Join Lakeshore Clinic</h1>
                <p class="text-blue-200 text-center text-lg max-w-md">Register as a medical professional and join our healthcare team.</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col">
            <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-text-primary mb-2">Doctor Registration</h2>
                        <p class="text-text-secondary">Complete your registration to join our team</p>
                    </div>

                    <form id="registration-form" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" placeholder="Dr. John Smith">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" required class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" placeholder="doctor@example.com">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary mb-1.5">Phone Number</label>
                            <input type="text" name="phone" class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Medical License Number</label>
                                <input type="text" name="license_number" class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Qualification</label>
                                <input type="text" name="qualification" class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" placeholder="e.g., MBBS, MD">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Years of Experience</label>
                                <input type="number" name="years_of_experience" min="0" class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-1.5">Specialization</label>
                                <select name="specialization_id" class="w-full px-3 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                    <option value="">Select Specialization</option>
                                    @foreach($specializations as $spec)
                                        <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" id="register-btn" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-[#1e3a5f] rounded-lg hover:bg-[#2d5a87] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f] transition-colors">
                            <span id="register-btn-text">Submit Registration</span>
                            <svg id="register-btn-spinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>

                    <div id="registration-success" class="hidden text-center py-12">
                        <div class="w-20 h-20 mx-auto rounded-full bg-health-100 flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-text-primary mb-2">Registration Submitted!</h2>
                        <p class="text-text-secondary mb-6">Your registration has been submitted for review. You will receive an email once approved.</p>
                        <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6 text-center text-sm text-text-muted">
                &copy; {{ date('Y') }} Lakeshore Clinic. All rights reserved.
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registration-form');
        const btn = document.getElementById('register-btn');
        const btnText = document.getElementById('register-btn-text');
        const btnSpinner = document.getElementById('register-btn-spinner');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            btn.disabled = true;
            btnText.textContent = 'Submitting...';
            btnSpinner.classList.remove('hidden');

            try {
                const formData = new FormData(form);
                const response = await fetch('{{ route("doctor.register") }}', {
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
                    form.classList.add('hidden');
                    document.getElementById('registration-success').classList.remove('hidden');
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showToast(data.errors[field][0], 'error');
                        });
                    } else {
                        showToast(data.message || 'Registration failed.', 'error');
                    }
                }
            } catch (error) {
                showToast('An error occurred. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Submit Registration';
                btnSpinner.classList.add('hidden');
            }
        });
    });
    </script>
</body>
</html>
