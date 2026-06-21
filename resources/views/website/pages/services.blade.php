@extends('website.layouts.master')

@section('title', 'Our Services - Lakeshore Clinic')
@section('meta-description', 'Explore the full range of healthcare services offered at Lakeshore Clinic including general practice, telemedicine, specialist care, wellness programs, and pharmacy.')

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">Our Services</span>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold text-slate-900">Comprehensive Healthcare Solutions</h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">From preventive care to specialized treatments, we deliver a full spectrum of medical services designed around you.</p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $services = [
                    ['title' => 'General Practice', 'desc' => 'Comprehensive primary care for patients of all ages, including preventive care, chronic disease management, and health screenings.', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                    ['title' => 'Telemedicine', 'desc' => 'Virtual consultations from the comfort of your home. Secure, HIPAA-compliant video visits with our experienced physicians.', 'icon' => 'M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z'],
                    ['title' => 'Specialist Care', 'desc' => 'Expert consultations across cardiology, dermatology, neurology, orthopedics, and more.', 'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
                    ['title' => 'Wellness Programs', 'desc' => 'Holistic wellness plans including nutrition counseling, fitness programs, and lifestyle coaching.', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z'],
                    ['title' => 'Pharmacy', 'desc' => 'On-site MediCORE Pharmacy with prescription filling, medication counseling, and health products.', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                    ['title' => 'Emergency Care', 'desc' => '24/7 emergency medical services with experienced emergency physicians and modern facilities.', 'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z'],
                    ['title' => 'Diagnostics', 'desc' => 'Advanced laboratory testing, medical imaging, and diagnostic services with quick turnaround times.', 'icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z'],
                    ['title' => 'Preventive Care', 'desc' => 'Health screenings, vaccinations, and preventive wellness programs to keep you at your best.', 'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z'],
                    ['title' => 'Pediatrics', 'desc' => 'Specialized healthcare for infants, children, and adolescents in a friendly environment.', 'icon' => 'M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z'],
                ];
            @endphp

            @foreach($services as $service)
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

<section class="py-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Ready to Experience Our Services?</h2>
        <p class="text-lg text-slate-600 mb-8">Schedule an appointment today and discover why thousands trust Lakeshore Clinic for their healthcare needs.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('website.book-online') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-white bg-[#0d4f4f] hover:bg-[#0a3d3d] rounded-xl shadow-lg shadow-[#0d4f4f]/25 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Book an Appointment
            </a>
            <a href="{{ route('website.contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection
