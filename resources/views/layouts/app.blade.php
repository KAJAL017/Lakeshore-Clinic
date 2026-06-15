<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Lakeshore Clinic'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-surface">
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <div id="confirmation-dialog" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-text-primary">Confirm Action</h3>
                </div>
            </div>
            <p class="confirm-message text-text-secondary mb-6"></p>
            <div class="flex justify-end gap-3">
                <button class="cancel-btn px-4 py-2 text-sm font-medium text-text-secondary bg-surface rounded-lg border border-surface-border hover:bg-gray-100 transition-colors">
                    Cancel
                </button>
                <button class="confirm-btn px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <div class="flex h-full">
        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-h-full lg:ml-64 sidebar-transition" id="main-content">
            @include('layouts.partials.header')

            <main class="flex-1 p-4 lg:p-6">
                @if(isset($breadcrumbs))
                    <x-breadcrumb :items="$breadcrumbs" class="mb-4" />
                @endif
                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <div id="mobile-overlay" class="hidden fixed inset-0 bg-black/50 z-30 lg:hidden"></div>

    @stack('scripts')
</body>
</html>
