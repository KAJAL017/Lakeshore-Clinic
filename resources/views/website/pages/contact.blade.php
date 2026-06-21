@extends('website.layouts.master')

@section('title', 'Contact Us - Lakeshore Clinic')
@section('meta-description', 'Get in touch with Lakeshore Clinic. Visit us, call us, or send us a message. We are here to help with your healthcare needs.')

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <span class="text-sm font-semibold text-[#0d4f4f] uppercase tracking-wider">Contact Us</span>
        <h1 class="mt-3 text-4xl sm:text-5xl font-bold text-slate-900">We're Here to Help</h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">Have questions or need to schedule an appointment? Reach out to our team and we'll get back to you promptly.</p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Get in Touch</h2>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-1">Visit Us</h3>
                            <p class="text-slate-600">123 Lakeshore Drive<br>Toronto, ON M5V 2T6</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-1">Call Us</h3>
                            <a href="tel:+18005551234" class="text-slate-600 hover:text-[#0d4f4f] transition-colors">(800) 555-1234</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-1">Email Us</h3>
                            <a href="mailto:info@lakeshoreclinic.com" class="text-slate-600 hover:text-[#0d4f4f] transition-colors">info@lakeshoreclinic.com</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-1">Hours</h3>
                            <p class="text-slate-600">Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 2:00 PM<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Send a Message</h2>
                <form id="contact-form" class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="contact-name" class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                            <input type="text" id="contact-name" name="name" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0d4f4f]/20 focus:border-[#0d4f4f] transition-all"
                                   placeholder="Your full name">
                        </div>
                        <div>
                            <label for="contact-email" class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                            <input type="email" id="contact-email" name="email" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0d4f4f]/20 focus:border-[#0d4f4f] transition-all"
                                   placeholder="your@email.com">
                        </div>
                    </div>
                    <div>
                        <label for="contact-phone" class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number</label>
                        <input type="tel" id="contact-phone" name="phone"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0d4f4f]/20 focus:border-[#0d4f4f] transition-all"
                               placeholder="(555) 123-4567">
                    </div>
                    <div>
                        <label for="contact-subject" class="block text-sm font-medium text-slate-700 mb-1.5">Subject</label>
                        <select id="contact-subject" name="subject"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0d4f4f]/20 focus:border-[#0d4f4f] transition-all">
                            <option value="">Select a subject</option>
                            <option value="appointment">Appointment Inquiry</option>
                            <option value="general">General Question</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="contact-message" class="block text-sm font-medium text-slate-700 mb-1.5">Message</label>
                        <textarea id="contact-message" name="message" rows="5" required
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0d4f4f]/20 focus:border-[#0d4f4f] transition-all resize-none"
                                  placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    <button type="submit" id="contact-submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-white bg-[#0d4f4f] hover:bg-[#0a3d3d] rounded-xl shadow-lg shadow-[#0d4f4f]/25 transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-[#0d4f4f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Need Immediate Assistance?</h2>
        <p class="text-teal-200 text-lg mb-8">For emergencies, call our 24/7 helpline or visit the nearest emergency room.</p>
        <a href="tel:+18005551234" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-[#0d4f4f] bg-white hover:bg-slate-50 rounded-xl transition-all duration-300">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
            Call (800) 555-1234
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function() {
    var form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('contact-submit');
        var originalText = btn.innerHTML;
        btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Sending...';
        btn.disabled = true;

        setTimeout(function() {
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg> Message Sent!';
            btn.classList.remove('bg-[#0d4f4f]', 'hover:bg-[#0a3d3d]');
            btn.classList.add('bg-emerald-600');

            if (typeof window.showToast === 'function') {
                window.showToast('Your message has been sent successfully. We will get back to you shortly.', 'success');
            }

            setTimeout(function() {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.add('bg-[#0d4f4f]', 'hover:bg-[#0a3d3d]');
                btn.classList.remove('bg-emerald-600');
                form.reset();
            }, 3000);
        }, 1500);
    });
})();
</script>
@endpush
