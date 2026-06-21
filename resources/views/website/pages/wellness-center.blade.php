@extends('website.layouts.master')

@section('title', 'Wellness Center - Lakeshore Clinic')
@section('meta-description', 'Lakeshore Wellness Center - holistic wellness programs including fitness, nutrition, mental health, and lifestyle coaching.')

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">Wellness Center</span>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold text-slate-900">Holistic Wellness Programs</h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Comprehensive wellness programs designed to help you achieve optimal health and well-being.</p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $wellnessServices = [
                    ['title' => 'Nutrition Counseling', 'desc' => 'Personalized nutrition plans and dietary guidance from certified nutritionists.', 'icon' => 'M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.379a48.474 48.474 0 00-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265z'],
                    ['title' => 'Fitness Programs', 'desc' => 'Guided exercise programs tailored to your fitness level and health goals.', 'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z'],
                    ['title' => 'Mental Health', 'desc' => 'Professional counseling and therapy services for mental well-being.', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
                    ['title' => 'Stress Management', 'desc' => 'Techniques and programs to help manage stress and improve quality of life.', 'icon' => 'M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z'],
                    ['title' => 'Lifestyle Coaching', 'desc' => 'One-on-one coaching to help you build sustainable healthy habits.', 'icon' => 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.841m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z'],
                    ['title' => 'Health Screenings', 'desc' => 'Comprehensive health assessments and preventive screenings.', 'icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z'],
                ];
            @endphp

            @foreach($wellnessServices as $service)
                <div class="p-8 bg-slate-50 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $service['title'] }}</h3>
                    <p class="text-slate-600 leading-relaxed">{{ $service['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
