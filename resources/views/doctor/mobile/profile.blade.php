@extends('layouts.doctor-mobile')

@section('title', 'My Profile - Lakeshore Clinic')
@section('page-title', 'My Profile')

@section('content')
<div class="space-y-5">

    {{-- Profile Header --}}
    <div class="bg-gradient-to-br from-[#1e3a5f] via-[#2a4a7a] to-[#1e3a5f] rounded-3xl p-6 text-center relative overflow-hidden shadow-xl">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
        </div>

        <div class="relative">
            {{-- Avatar --}}
            <div class="relative inline-block">
                <div id="mobile-photo-preview" class="w-24 h-24 rounded-full mx-auto ring-4 ring-white/20 overflow-hidden bg-white/10 flex items-center justify-center shadow-lg">
                    @if($doctor && !empty($doctor->photo))
                        <img src="{{ asset('uploads/doctors/' . $doctor->photo) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-white">{{ strtoupper(substr($doctor->first_name ?? auth()->user()->name ?? 'D', 0, 1)) }}{{ strtoupper(substr($doctor->last_name ?? '', 0, 1)) }}</span>
                    @endif
                </div>
                <button id="change-photo-btn" class="absolute bottom-0 right-0 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-lg active:scale-90 transition-transform">
                    <svg class="w-4 h-4 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
                <input type="file" id="photo-input" accept="image/*" class="hidden">
            </div>

            {{-- Name & Role --}}
            <h1 class="text-white text-xl font-bold mt-3">
                Dr. {{ $doctor->first_name ?? auth()->user()->name ?? '' }} {{ $doctor->last_name ?? '' }}
            </h1>
            <p class="text-blue-200 text-sm mt-0.5">{{ auth()->user()->email }}</p>

            <div class="flex items-center justify-center gap-2 mt-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                    @if(($doctor->status ?? '') === 'active') bg-emerald-400/20 text-emerald-200
                    @else bg-amber-400/20 text-amber-200 @endif">
                    {{ ucfirst($doctor->status ?? 'active') }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                    @if(($doctor->approval_status ?? '') === 'approved') bg-blue-400/20 text-blue-200
                    @else bg-amber-400/20 text-amber-200 @endif">
                    {{ ucfirst($doctor->approval_status ?? 'pending') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Account Information --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Account
            </h2>
        </div>
        <div class="p-5 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Email</p>
                    <p class="text-sm text-gray-900 font-semibold truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Phone</p>
                    <p class="text-sm text-gray-900 font-semibold">{{ $doctor->phone ?? 'Not provided' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Status</p>
                    <p class="text-sm font-semibold {{ ($doctor->status ?? '') === 'active' ? 'text-emerald-600' : 'text-amber-600' }}">{{ ucfirst($doctor->status ?? 'active') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Member Since</p>
                    <p class="text-sm text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($doctor->created_at ?? auth()->user()->created_at)->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Professional Details --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                Professional Details
            </h2>
        </div>
        <div class="p-5 space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">License Number</p>
                    <p class="text-sm text-gray-900 font-semibold">{{ $doctor->license_number ?? 'Not provided' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Qualification</p>
                    <p class="text-sm text-gray-900 font-semibold">{{ $doctor->qualification ?? 'Not provided' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Years of Experience</p>
                    <p class="text-sm text-gray-900 font-semibold">{{ $doctor->years_of_experience ?? 0 }} years</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Address</p>
                    <p class="text-sm text-gray-900 font-semibold leading-relaxed">{{ $doctor->address ?? 'Not provided' }}</p>
                </div>
            </div>

            @if(!empty($doctor->biography))
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-400 font-medium">Biography</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $doctor->biography }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="space-y-3">
        {{-- Edit Profile --}}
        <button onclick="openEditSheet()" class="w-full flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 active:bg-gray-50 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div class="flex-1 text-left">
                <p class="text-sm font-semibold text-gray-900">Edit Profile</p>
                <p class="text-xs text-gray-400">Update your personal information</p>
            </div>
            <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- Change Password --}}
        <button onclick="openPasswordSheet()" class="w-full flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 active:bg-gray-50 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div class="flex-1 text-left">
                <p class="text-sm font-semibold text-gray-900">Change Password</p>
                <p class="text-xs text-gray-400">Update your account password</p>
            </div>
            <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- Logout --}}
        <button id="logout-btn" class="w-full flex items-center justify-center gap-2 bg-white rounded-2xl p-4 shadow-sm border border-red-100 text-red-500 active:bg-red-50 transition-colors mt-6">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span class="text-sm font-semibold">Logout</span>
        </button>
    </div>

    <div class="h-4"></div>
</div>

{{-- Edit Profile Bottom Sheet --}}
<div id="edit-profile-sheet" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeEditSheet()"></div>
    <div id="edit-profile-panel" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-out max-h-[85vh] flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 flex-shrink-0">
            <h3 class="text-lg font-bold text-gray-900">Edit Profile</h3>
            <button onclick="closeEditSheet()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center active:bg-gray-200 transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-5">
            <form id="edit-profile-form" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ $doctor->phone ?? '' }}" placeholder="+1 (555) 000-0000"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Qualification</label>
                    <input type="text" name="qualification" value="{{ $doctor->qualification ?? '' }}" placeholder="e.g. MD, MBBS"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Years of Experience</label>
                    <input type="number" name="years_of_experience" value="{{ $doctor->years_of_experience ?? 0 }}" min="0"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Address</label>
                    <textarea name="address" rows="2" placeholder="Your clinic address"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all resize-none">{{ $doctor->address ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Biography</label>
                    <textarea name="biography" rows="3" placeholder="Tell patients about yourself"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all resize-none">{{ $doctor->biography ?? '' }}</textarea>
                </div>
            </form>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex-shrink-0 pb-safe">
            <button id="save-profile-btn" onclick="submitEditProfile()" class="w-full py-3.5 bg-[#1e3a5f] text-white font-semibold rounded-xl active:bg-[#152c4a] transition-colors flex items-center justify-center gap-2">
                <span id="save-profile-text">Save Changes</span>
                <svg id="save-profile-spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </button>
        </div>
    </div>
</div>

{{-- Change Password Bottom Sheet --}}
<div id="password-sheet" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePasswordSheet()"></div>
    <div id="password-panel" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-out max-h-[85vh] flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 flex-shrink-0">
            <h3 class="text-lg font-bold text-gray-900">Change Password</h3>
            <button onclick="closePasswordSheet()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center active:bg-gray-200 transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-5">
            <form id="password-form" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Current Password</label>
                    <input type="password" name="current_password" required placeholder="Enter current password"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">New Password</label>
                    <input type="password" name="password" required placeholder="Enter new password"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Confirm new password"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                </div>
            </form>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex-shrink-0 pb-safe">
            <button id="save-password-btn" onclick="submitPasswordChange()" class="w-full py-3.5 bg-[#1e3a5f] text-white font-semibold rounded-xl active:bg-[#152c4a] transition-colors flex items-center justify-center gap-2">
                <span id="save-password-text">Update Password</span>
                <svg id="save-password-spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo Upload
    const changePhotoBtn = document.getElementById('change-photo-btn');
    const photoInput = document.getElementById('photo-input');

    changePhotoBtn.addEventListener('click', function(e) {
        e.preventDefault();
        photoInput.click();
    });

    photoInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            showToast('File size must be less than 5MB.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('photo', file);

        try {
            const response = await fetch('{{ route("doctor.profile.photo") }}', {
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
                const preview = document.getElementById('mobile-photo-preview');
                preview.innerHTML = '<img src="' + data.photo_url + '" alt="Profile" class="w-full h-full object-cover">';
            } else {
                showToast(data.message || 'Failed to upload photo.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        }

        photoInput.value = '';
    });

    // Edit Profile Bottom Sheet
    window.openEditSheet = function() {
        const sheet = document.getElementById('edit-profile-sheet');
        const panel = document.getElementById('edit-profile-panel');
        sheet.classList.remove('hidden');
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                panel.style.transform = 'translateY(0)';
            });
        });
    };

    window.closeEditSheet = function() {
        const panel = document.getElementById('edit-profile-panel');
        const sheet = document.getElementById('edit-profile-sheet');
        panel.style.transform = 'translateY(100%)';
        setTimeout(function() { sheet.classList.add('hidden'); }, 300);
    };

    // Password Bottom Sheet
    window.openPasswordSheet = function() {
        const sheet = document.getElementById('password-sheet');
        const panel = document.getElementById('password-panel');
        sheet.classList.remove('hidden');
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                panel.style.transform = 'translateY(0)';
            });
        });
    };

    window.closePasswordSheet = function() {
        const panel = document.getElementById('password-panel');
        const sheet = document.getElementById('password-sheet');
        panel.style.transform = 'translateY(100%)';
        setTimeout(function() {
            sheet.classList.add('hidden');
            document.getElementById('password-form').reset();
        }, 300);
    };

    // Submit Edit Profile
    window.submitEditProfile = async function() {
        const btn = document.getElementById('save-profile-btn');
        const btnText = document.getElementById('save-profile-text');
        const btnSpinner = document.getElementById('save-profile-spinner');

        btn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');

        try {
            const formData = new FormData(document.getElementById('edit-profile-form'));
            const response = await fetch('{{ route("doctor.profile.update") }}', {
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
                closeEditSheet();
                setTimeout(function() { location.reload(); }, 400);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(function(key) {
                        showToast(data.errors[key][0], 'error');
                    });
                } else {
                    showToast(data.message || 'Failed to update profile.', 'error');
                }
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Save Changes';
            btnSpinner.classList.add('hidden');
        }
    };

    // Submit Password Change
    window.submitPasswordChange = async function() {
        const btn = document.getElementById('save-password-btn');
        const btnText = document.getElementById('save-password-text');
        const btnSpinner = document.getElementById('save-password-spinner');

        btn.disabled = true;
        btnText.textContent = 'Updating...';
        btnSpinner.classList.remove('hidden');

        try {
            const formData = new FormData(document.getElementById('password-form'));
            const response = await fetch('{{ route("doctor.profile.password") }}', {
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
                closePasswordSheet();
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(function(key) {
                        showToast(data.errors[key][0], 'error');
                    });
                } else {
                    showToast(data.message || 'Failed to update password.', 'error');
                }
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Update Password';
            btnSpinner.classList.add('hidden');
        }
    };
});
</script>
@endpush
