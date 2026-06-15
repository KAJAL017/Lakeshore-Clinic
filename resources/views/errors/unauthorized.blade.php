@extends('layouts.app')

@section('title', 'Unauthorized - Lakeshore Clinic')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
    <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mb-6">
        <svg class="w-12 h-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
        </svg>
    </div>
    <h1 class="text-3xl font-bold text-text-primary mb-2">Access Denied</h1>
    <p class="text-text-secondary mb-6 max-w-md">You don't have permission to access this page. Please contact your administrator if you believe this is an error.</p>
    <div class="flex items-center gap-3">
        <x-button variant="primary" href="{{ route('dashboard') }}">Go to Dashboard</x-button>
        <x-button variant="outline" href="{{ route('login') }}">Login Again</x-button>
    </div>
</div>
@endsection
