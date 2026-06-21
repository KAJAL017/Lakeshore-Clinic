@extends('website.layouts.master')

@section('title', 'About Us - Lakeshore Clinic')
@section('meta-description', 'Learn about Lakeshore Clinic - our mission, values, and commitment to providing premium healthcare services.')

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">About Us</span>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold text-slate-900">Our Story</h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Dedicated to providing compassionate, world-class healthcare for our community.</p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-6">Excellence in Healthcare Since 2010</h2>
                <p class="text-slate-600 leading-relaxed mb-6">Lakeshore Clinic was founded with a simple mission: to provide accessible, high-quality healthcare to every patient who walks through our doors. Over the years, we have grown from a small practice to a comprehensive medical center serving thousands of patients annually.</p>
                <p class="text-slate-600 leading-relaxed">Our team of board-certified physicians, specialists, and healthcare professionals are committed to delivering personalized care that puts patients first.</p>
            </div>
            <div class="bg-slate-100 rounded-2xl h-80 flex items-center justify-center">
                <span class="text-slate-400 text-sm">Clinic Photo Placeholder</span>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-[#0d4f4f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-white mb-2">15+</div>
                <div class="text-teal-200">Years of Service</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">50+</div>
                <div class="text-teal-200">Medical Professionals</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">25K+</div>
                <div class="text-teal-200">Patients Served</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">98%</div>
                <div class="text-teal-200">Patient Satisfaction</div>
            </div>
        </div>
    </div>
</section>
@endsection
