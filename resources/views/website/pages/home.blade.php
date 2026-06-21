@extends('website.layouts.master')

@section('title', 'Lakeshore Clinic - Premium Healthcare & Medical Center')
@section('meta-description', 'Lakeshore Clinic provides premium healthcare services including general practice, telemedicine, specialist care, and wellness programs.')

@section('content')
<section id="hero" style="position: relative; width: 100%; height: 850px; overflow: hidden;" aria-label="Hero">
    <div style="position: absolute; inset: 0;">
        <img
            src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1920&q=80"
            alt="Premium medical clinic interior with modern wellness atmosphere"
            style="width: 100%; height: 100%; object-fit: cover;"
            loading="eager"
        >
        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.08);"></div>
    </div>

    <div id="hero-card" style="
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        padding: 0 20px;
    ">
        <div style="
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 50px rgba(0,0,0,0.12);
            width: 70%;
            min-height: 650px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 90px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.9s ease, transform 0.9s ease;
        " id="hero-panel">
            <div style="text-align: center; width: 100%;">
                <h1 style="
                    font-family: 'Playfair Display', Georgia, serif;
                    font-weight: 400;
                    color: #111111;
                    line-height: 0.9;
                    letter-spacing: normal;
                    font-size: 100px;
                    margin: 0;
                    padding: 0;
                ">
                    Excellence in<br>Medical Care &<br>Wellness
                </h1>

                <p style="
                    font-family: 'Inter', sans-serif;
                    font-weight: 400;
                    color: #444444;
                    line-height: 1.5;
                    max-width: 850px;
                    margin: 50px auto 0;
                    font-size: 30px;
                ">
                    Delivering compassionate, world-class healthcare with a focus on patient-centered excellence, advanced treatments, and holistic wellness for every individual.
                </p>

                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 30px;
                    margin-top: 60px;
                ">
                    <a href="{{ route('login') }}" style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        height: 70px;
                        min-width: 260px;
                        padding: 0 40px;
                        font-family: 'Inter', sans-serif;
                        font-size: 24px;
                        font-weight: 600;
                        color: #ffffff;
                        background-color: #0d4f4f;
                        border: 2px solid #0d4f4f;
                        border-radius: 9999px;
                        text-decoration: none;
                        transition: all 0.3s ease;
                        cursor: pointer;
                    " onmouseover="this.style.backgroundColor='#093a3a'; this.style.borderColor='#093a3a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 30px rgba(13,79,79,0.3)'"
                       onmouseout="this.style.backgroundColor='#0d4f4f'; this.style.borderColor='#0d4f4f'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Register as a Patient
                    </a>
                    <a href="#services" style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        height: 70px;
                        min-width: 260px;
                        padding: 0 40px;
                        font-family: 'Inter', sans-serif;
                        font-size: 24px;
                        font-weight: 600;
                        color: #0d4f4f;
                        background-color: #ffffff;
                        border: 2px solid #0d4f4f;
                        border-radius: 9999px;
                        text-decoration: none;
                        transition: all 0.3s ease;
                        cursor: pointer;
                    " onmouseover="this.style.backgroundColor='#0d4f4f'; this.style.color='#ffffff'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 30px rgba(13,79,79,0.3)'"
                       onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#0d4f4f'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Explore Services
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        #hero { min-height: 650px; }
        @media (max-width: 1024px) {
            #hero { height: 750px; }
            #hero-card > div { width: 75%; padding: 70px 60px; min-height: 550px; }
            #hero-card h1 { font-size: 80px; }
            #hero-card p { font-size: 24px; }
        }
        @media (max-width: 768px) {
            #hero { height: auto; min-height: unset; padding: 80px 0; }
            #hero-card { height: auto; min-height: unset; padding: 30px 16px; }
            #hero-card > div { width: 95%; min-height: unset; padding: 50px 28px; }
            #hero-card h1 { font-size: 50px; }
            #hero-card p { font-size: 18px; margin-top: 35px; }
            #hero-card div:last-child { flex-direction: column; gap: 20px !important; margin-top: 45px !important; }
            #hero-card a { min-width: 100% !important; height: 60px !important; font-size: 18px !important; }
        }
    </style>
</section>

<section id="virtual-care" style="background-color: #F5F6F4; padding: 100px 0;" aria-label="Virtual Medical Care">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 40px;">
        <div style="display: grid; grid-template-columns: 1fr; gap: 70px; align-items: start;" class="virtual-care-grid">

            <div class="virtual-care-left">
                <h2 style="
                    font-family: 'Playfair Display', Georgia, serif;
                    font-weight: 400;
                    color: #111111;
                    line-height: 0.95;
                    font-size: 80px;
                    margin: 0 0 40px 0;
                    padding: 0;
                ">Virtual Medical Care,<br>Wherever You Are</h2>

                <p style="
                    font-family: 'Inter', sans-serif;
                    font-weight: 400;
                    color: #555555;
                    line-height: 1.6;
                    max-width: 700px;
                    font-size: 26px;
                    margin: 0 0 50px 0;
                ">Experience world-class healthcare from the comfort of your home. Our secure telemedicine platform connects you with experienced physicians for personalized virtual consultations.</p>

                <div class="virtual-care-steps">
                    <div class="virtual-step">
                        <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 56px; color: #0d4f4f; font-weight: 400; margin-bottom: 16px;">01</div>
                        <div style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: 500; color: #111111; margin-bottom: 14px;">Book your virtual visit</div>
                        <div style="font-family: 'Inter', sans-serif; font-size: 22px; color: #666666; line-height: 1.5; margin-bottom: 40px;">Choose your doctor and time in our secure booking system.</div>
                        <div style="height: 1px; background-color: #e0e0e0; margin-bottom: 45px;"></div>
                    </div>
                    <div class="virtual-step">
                        <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 56px; color: #0d4f4f; font-weight: 400; margin-bottom: 16px;">02</div>
                        <div style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: 500; color: #111111; margin-bottom: 14px;">Receive your private link</div>
                        <div style="font-family: 'Inter', sans-serif; font-size: 22px; color: #666666; line-height: 1.5; margin-bottom: 40px;">We send a unique encrypted consultation link.</div>
                        <div style="height: 1px; background-color: #e0e0e0; margin-bottom: 45px;"></div>
                    </div>
                    <div class="virtual-step">
                        <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 56px; color: #0d4f4f; font-weight: 400; margin-bottom: 16px;">03</div>
                        <div style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: 500; color: #111111; margin-bottom: 14px;">Join your consultation</div>
                        <div style="font-family: 'Inter', sans-serif; font-size: 22px; color: #666666; line-height: 1.5; margin-bottom: 0;">Join from any device at your appointment time.</div>
                    </div>
                </div>
            </div>

            <div class="virtual-care-right">
                <div class="virtual-portal-card">
                    <div style="
                        display: inline-block;
                        background-color: #e6f4f1;
                        color: #0d4f4f;
                        font-family: 'Inter', sans-serif;
                        font-size: 14px;
                        font-weight: 600;
                        letter-spacing: 2px;
                        text-transform: uppercase;
                        padding: 10px 24px;
                        border-radius: 9999px;
                        margin-bottom: 40px;
                    ">PATIENT PORTAL</div>

                    <h3 style="
                        font-family: 'Playfair Display', Georgia, serif;
                        font-weight: 400;
                        font-size: 52px;
                        color: #111111;
                        margin: 0 0 30px 0;
                        line-height: 1.1;
                    ">Virtual Consultation<br>Experience</h3>

                    <p style="
                        font-family: 'Inter', sans-serif;
                        font-size: 22px;
                        color: #555555;
                        line-height: 1.7;
                        margin: 0 0 45px 0;
                    ">Connect with our board-certified physicians through a seamless, HIPAA-compliant virtual platform designed for your comfort and privacy.</p>

                    <a href="{{ route('login') }}" class="virtual-cta-button" style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                        height: 70px;
                        background-color: #0d4f4f;
                        color: #ffffff;
                        font-family: 'Inter', sans-serif;
                        font-size: 22px;
                        font-weight: 500;
                        text-decoration: none;
                        border-radius: 9999px;
                        transition: all 0.3s ease;
                        margin-bottom: 35px;
                    ">Schedule Virtual Consultation</a>

                    <div style="
                        font-family: 'Inter', sans-serif;
                        font-size: 18px;
                        color: #777777;
                        text-align: center;
                        line-height: 1.6;
                    ">
                        <svg style="display: inline-block; vertical-align: middle; margin-right: 8px; width: 20px; height: 20px; fill: none; stroke: #777777; stroke-width: 2;" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                        End-to-end encrypted &amp; HIPAA compliant
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .virtual-care-grid {
            grid-template-columns: 60% 40%;
        }
        .virtual-portal-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 80px rgba(0,0,0,0.08);
            padding: 50px;
        }
        .virtual-cta-button:hover {
            background-color: #093a3a !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(13,79,79,0.3);
        }
        .virtual-step:last-child div:last-child {
            margin-bottom: 0 !important;
        }
        .virtual-step:last-child {
            margin-bottom: 0;
        }
        .virtual-step:last-child > div:nth-child(4) {
            display: none;
        }
        @media (max-width: 1024px) {
            .virtual-care-grid {
                grid-template-columns: 1fr !important;
            }
            .virtual-care-left h2 {
                font-size: 60px !important;
            }
            .virtual-care-left > p {
                font-size: 22px !important;
            }
        }
        @media (max-width: 768px) {
            #virtual-care {
                padding: 70px 0 !important;
            }
            #virtual-care > div {
                padding: 0 20px !important;
            }
            .virtual-care-left h2 {
                font-size: 42px !important;
                line-height: 1.0 !important;
            }
            .virtual-care-left > p {
                font-size: 18px !important;
            }
            .virtual-care-left .virtual-step div:nth-child(1) {
                font-size: 40px !important;
            }
            .virtual-care-left .virtual-step div:nth-child(2) {
                font-size: 28px !important;
            }
            .virtual-care-left .virtual-step div:nth-child(3) {
                font-size: 18px !important;
            }
            .virtual-portal-card {
                padding: 35px 25px !important;
            }
            .virtual-portal-card h3 {
                font-size: 36px !important;
            }
            .virtual-portal-card > p {
                font-size: 18px !important;
            }
        }
    </style>

    <script>
    (function() {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        var targets = document.querySelectorAll('#virtual-care .virtual-care-left, #virtual-care .virtual-care-right');
        targets.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });
    })();
    </script>
</section>

<section id="services" class="py-16 lg:py-24 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">Our Services</span>
            <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-slate-900">Comprehensive Healthcare Solutions</h2>
            <p class="mt-4 text-lg text-slate-600">From preventive care to specialized treatments, we offer a full spectrum of medical services.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @php
                $services = [
                    ['title' => 'General Practice', 'desc' => 'Comprehensive primary care for patients of all ages.', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                    ['title' => 'Telemedicine', 'desc' => 'Virtual consultations from the comfort of your home.', 'icon' => 'M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z'],
                    ['title' => 'Specialist Care', 'desc' => 'Expert consultations across multiple specialties.', 'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
                    ['title' => 'Wellness Programs', 'desc' => 'Holistic wellness plans for a healthier lifestyle.', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z'],
                    ['title' => 'Pharmacy', 'desc' => 'On-site pharmacy for your convenience.', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                    ['title' => 'Emergency Care', 'desc' => '24/7 emergency services when you need us most.', 'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z'],
                ];
            @endphp

            @foreach($services as $service)
                <div class="group relative p-6 lg:p-8 bg-slate-50 hover:bg-white rounded-2xl border border-transparent hover:border-slate-200 hover:shadow-xl hover:shadow-slate-100 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $service['title'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $service['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="book-appointment" class="py-16 lg:py-24 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="w-full px-4 sm:px-6 lg:px-10">
        <div class="max-w-3xl mx-auto text-center">
            <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">Get Started</span>
            <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-slate-900">Ready to Book Your Appointment?</h2>
            <p class="mt-4 text-lg text-slate-600">Schedule a visit with our expert medical team today.</p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-white bg-[#0d4f4f] hover:bg-[#0a3d3d] rounded-xl shadow-lg shadow-[#0d4f4f]/25 hover:shadow-[#0d4f4f]/40 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Book Now
                </a>
                <a href="tel:+18005551234"
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    Call Us: (800) 555-1234
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function() {
    var panel = document.getElementById('hero-panel');
    if (!panel) return;

    requestAnimationFrame(function() {
        requestAnimationFrame(function() {
            panel.style.opacity = '1';
            panel.style.transform = 'translateY(0)';
        });
    });
})();
</script>
@endpush
