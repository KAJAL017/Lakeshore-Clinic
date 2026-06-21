<div id="mobile-menu"
     class="fixed inset-0 z-40 lg:hidden"
     role="dialog"
     aria-modal="true"
     aria-label="Mobile navigation"
     aria-hidden="true">

    <div id="mobile-menu-overlay"
         class="absolute inset-0 bg-black/30 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    </div>

    <div id="mobile-menu-panel"
         class="absolute inset-y-0 right-0 w-full max-w-sm bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-out">

        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#0d4f4f]">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <span class="text-base font-semibold text-[#1a1a1a]">Lakeshore<span class="font-light text-[#0d4f4f] ml-0.5">Clinic</span></span>
            </a>
            <button id="mobile-menu-close"
                    class="flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                    aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="px-4 py-6 overflow-y-auto h-[calc(100%-73px)]">
            <nav class="space-y-1" aria-label="Mobile navigation">
                @php
                    $mobileNavItems = [
                        ['label' => 'Home', 'url' => route('home'), 'icon' => 'home'],
                        ['label' => 'About Us', 'url' => route('website.about'), 'icon' => 'info'],
                        ['label' => 'Medical Center', 'url' => route('website.medical-center'), 'icon' => 'medical'],
                        ['label' => 'MediCORE Pharmacy', 'url' => route('website.pharmacy'), 'icon' => 'pharmacy'],
                        ['label' => 'Wellness Center', 'url' => route('website.wellness'), 'icon' => 'wellness'],
                        ['label' => 'Services', 'url' => route('website.services'), 'icon' => 'shield'],
                        ['label' => 'Book Online', 'url' => route('website.book-online'), 'icon' => 'book'],
                        ['label' => 'Contact', 'url' => route('website.contact'), 'icon' => 'contact'],
                    ];
                @endphp

                @foreach($mobileNavItems as $item)
                    @php
                        $isActive = request()->is(ltrim($item['url'], '/'));
                    @endphp
                    <a href="{{ $item['url'] }}"
                       class="flex items-center gap-3 px-4 py-3.5 text-[15px] font-medium rounded-lg transition-all duration-200
                              {{ $isActive
                                  ? 'text-[#0d4f4f] bg-teal-50'
                                  : 'text-[#222222] hover:text-[#0d4f4f] hover:bg-gray-50' }}">
                        @if($item['icon'] === 'home')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        @elseif($item['icon'] === 'info')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        @elseif($item['icon'] === 'medical')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                        @elseif($item['icon'] === 'pharmacy')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                        @elseif($item['icon'] === 'wellness')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        @elseif($item['icon'] === 'book')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        @elseif($item['icon'] === 'contact')
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-8 pt-6 border-t border-gray-100 space-y-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3.5 text-[15px] font-medium text-[#222222] hover:text-[#0d4f4f] hover:bg-gray-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
