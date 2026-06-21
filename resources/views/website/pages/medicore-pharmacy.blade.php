@extends('website.layouts.master')

@section('title', 'MediCORE Pharmacy - Lakeshore Clinic')
@section('meta-description', 'MediCORE Pharmacy - convenient on-site pharmacy services with prescription management and health products.')

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">MediCORE Pharmacy</span>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold text-slate-900">Your Trusted Pharmacy</h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Convenient on-site pharmacy services with expert pharmacists and comprehensive medication management.</p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-6">Prescription & Health Products</h2>
                <p class="text-slate-600 leading-relaxed mb-6">MediCORE Pharmacy provides a full range of pharmaceutical services, including prescription filling, medication counseling, and over-the-counter health products. Our licensed pharmacists are always available to answer your questions.</p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3 text-slate-600">
                        <svg class="w-5 h-5 text-[#0d4f4f] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Prescription filling and refills
                    </li>
                    <li class="flex items-center gap-3 text-slate-600">
                        <svg class="w-5 h-5 text-[#0d4f4f] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Medication counseling and reviews
                    </li>
                    <li class="flex items-center gap-3 text-slate-600">
                        <svg class="w-5 h-5 text-[#0d4f4f] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Over-the-counter health products
                    </li>
                    <li class="flex items-center gap-3 text-slate-600">
                        <svg class="w-5 h-5 text-[#0d4f4f] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Home delivery available
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-[#0d4f4f] hover:bg-[#0a3d3d] rounded-xl transition-all duration-300">
                    Learn More
                </a>
            </div>
            <div class="bg-slate-100 rounded-2xl h-96 flex items-center justify-center">
                <span class="text-slate-400 text-sm">Pharmacy Image Placeholder</span>
            </div>
        </div>
    </div>
</section>
@endsection
