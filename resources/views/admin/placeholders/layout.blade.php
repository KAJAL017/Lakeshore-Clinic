@props(['title' => '', 'description' => '', 'icon' => ''])

@extends('layouts.app')

@section('title', $title . ' - Lakeshore Clinic')
@section('page-title', $title)

@section('content')
<div class="space-y-6">
    <x-page-header :title="$title">
        <x-slot name="subtitle">{{ $description }}</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-12">
        <div class="flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 rounded-2xl bg-primary-50 flex items-center justify-center mb-6">
                @if($icon)
                    <div class="w-10 h-10 text-primary-500">{!! $icon !!}</div>
                @else
                    <svg class="w-10 h-10 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                @endif
            </div>
            <h2 class="text-xl font-semibold text-text-primary mb-2">Coming Soon</h2>
            <p class="text-text-secondary max-w-md mb-6">This module is under development. The {{ strtolower($title) }} feature will be available in a future update.</p>
            <x-button variant="primary" href="{{ route('admin.dashboard') }}">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </x-button>
        </div>
    </x-card>
</div>
@endsection
