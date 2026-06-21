@extends('website.layouts.master')

@section('title', 'Book Online - Lakeshore Clinic')
@section('meta-description', 'Book your appointment online with Lakeshore Clinic. Choose your doctor, select a time, and schedule your visit today.')

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">Book Online</span>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold text-slate-900">Schedule Your Appointment</h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Choose your preferred doctor, date, and time. Quick and easy online booking.</p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-teal-50 flex items-center justify-center mx-auto mb-8">
                <svg class="w-10 h-10 text-[#0d4f4f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Ready to Book?</h2>
            <p class="text-slate-600 mb-8 max-w-lg mx-auto">Sign in to your patient account to book an appointment with our doctors. You can choose between clinic visits and telemedicine consultations.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-white bg-[#0d4f4f] hover:bg-[#0a3d3d] rounded-xl shadow-lg shadow-[#0d4f4f]/25 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Sign In to Book
                </a>
                <a href="tel:+18005551234" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    Call Us to Book
                </a>
            </div>
        </div>

        <div class="mt-12 grid sm:grid-cols-3 gap-6">
            <div class="text-center p-6">
                <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#0d4f4f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 mb-1">Choose Your Doctor</h3>
                <p class="text-sm text-slate-600">Browse our team of experienced physicians</p>
            </div>
            <div class="text-center p-6">
                <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#0d4f4f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 mb-1">Select Date & Time</h3>
                <p class="text-sm text-slate-600">Find a slot that works for your schedule</p>
            </div>
            <div class="text-center p-6">
                <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#0d4f4f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 mb-1">Confirm Booking</h3>
                <p class="text-sm text-slate-600">Get instant confirmation and reminders</p>
            </div>
        </div>
    </div>
</section>
@endsection
