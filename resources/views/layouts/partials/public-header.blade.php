<header id="public-header" class="fixed top-0 left-0 right-0 z-50 bg-white border-b-[1.5px] border-blue-200/80">
    <div class="w-full px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between h-[95px]">

            <div class="flex items-center gap-6 shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group" aria-label="Lakeshore Clinic Home">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-gradient-to-br from-[#0d4f4f] to-[#1a7a7a] shadow-sm group-hover:shadow-md transition-shadow duration-200">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-[22px] font-semibold text-[#1a1a1a] tracking-tight leading-none">Lakeshore</span>
                        <span class="text-[22px] font-light text-[#0d4f4f] tracking-tight leading-none ml-0.5">Clinic</span>
                    </div>
                </a>
            </div>

            <nav class="hidden lg:flex items-center gap-0" role="navigation" aria-label="Main navigation">
                @php
                    $navItems = [
                        ['label' => 'Home', 'url' => url('/')],
                        ['label' => 'Medical Center', 'url' => '#services'],
                        ['label' => 'MediCORE Pharmacy', 'url' => '#pharmacy'],
                        ['label' => 'Wellness Center', 'url' => '#wellness'],
                        ['label' => 'Book Online', 'url' => '#book-appointment'],
                        ['label' => 'Access Our Services', 'url' => '#doctors'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $isActive = request()->is(ltrim($item['url'], '/'));
                    @endphp
                    <a href="{{ $item['url'] }}"
                       class="relative px-4 xl:px-5 py-2 text-[15px] font-normal tracking-wide transition-colors duration-200
                              {{ $isActive
                                  ? 'text-[#1a1a1a]'
                                  : 'text-[#222222] hover:text-[#0d4f4f]' }}
                              nav-link group"
                       aria-current="{{ $isActive ? 'page' : 'false' }}">
                        {{ $item['label'] }}
                        <span class="absolute bottom-[-2px] left-1/2 -translate-x-1/2 w-0 h-[1.5px] bg-[#0d4f4f] rounded-full transition-all duration-300 group-hover:w-full nav-underline {{ $isActive ? '!w-full' : '' }}"></span>
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center justify-center w-[45px] h-[45px] rounded-full bg-[#0d4f4f] hover:bg-[#0a3d3d] transition-colors duration-200 shrink-0" aria-label="Account">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>

                <button id="mobile-menu-toggle"
                        class="lg:hidden flex items-center justify-center w-10 h-10 rounded-lg text-[#222222] hover:bg-gray-100 transition-all duration-200"
                        aria-label="Toggle mobile menu"
                        aria-expanded="false"
                        aria-controls="mobile-menu">
                    <div class="relative w-5 h-5 flex flex-col justify-center items-center">
                        <span class="mobile-menu-bar absolute w-5 h-[1.5px] bg-current rounded-full transition-all duration-300 -translate-y-[7px]"></span>
                        <span class="mobile-menu-bar absolute w-5 h-[1.5px] bg-current rounded-full transition-all duration-300 opacity-100"></span>
                        <span class="mobile-menu-bar absolute w-5 h-[1.5px] bg-current rounded-full transition-all duration-300 translate-y-[7px]"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</header>

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
                @foreach($navItems as $index => $item)
                    @php
                        $isActive = request()->is(ltrim($item['url'], '/'));
                    @endphp
                    <a href="{{ $item['url'] }}"
                       class="flex items-center gap-3 px-4 py-3.5 text-[15px] font-medium rounded-lg transition-all duration-200
                              {{ $isActive
                                  ? 'text-[#0d4f4f] bg-teal-50'
                                  : 'text-[#222222] hover:text-[#0d4f4f] hover:bg-gray-50' }}">
                        @if($loop->first)
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        @elseif($loop->index == 1)
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                        @elseif($loop->index == 2)
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                        @elseif($loop->index == 3)
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        @elseif($loop->index == 4)
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#0d4f4f]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
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

<div id="header-spacer" class="h-[95px]"></div>

<script>
(function() {
    const header = document.getElementById('public-header');
    const spacer = document.getElementById('header-spacer');
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-menu-overlay');
    const mobilePanel = document.getElementById('mobile-menu-panel');
    const mobileClose = document.getElementById('mobile-menu-close');

    function handleScroll() {
        if (window.scrollY > 10) {
            header.classList.add('shadow-sm');
        } else {
            header.classList.remove('shadow-sm');
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    function openMobileMenu() {
        mobileMenu.classList.remove('pointer-events-none');
        mobileMenu.setAttribute('aria-hidden', 'false');
        mobileToggle.setAttribute('aria-expanded', 'true');
        mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
        mobileOverlay.classList.add('opacity-100');
        mobilePanel.classList.remove('translate-x-full');
        mobilePanel.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden';

        const bars = mobileToggle.querySelectorAll('.mobile-menu-bar');
        bars[0].style.transform = 'rotate(45deg) translate(3px, 3px)';
        bars[1].style.opacity = '0';
        bars[2].style.transform = 'rotate(-45deg) translate(3px, -3px)';
    }

    function closeMobileMenu() {
        mobileMenu.classList.add('pointer-events-none');
        mobileMenu.setAttribute('aria-hidden', 'true');
        mobileToggle.setAttribute('aria-expanded', 'false');
        mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
        mobileOverlay.classList.remove('opacity-100');
        mobilePanel.classList.add('translate-x-full');
        mobilePanel.classList.remove('translate-x-0');
        document.body.style.overflow = '';

        const bars = mobileToggle.querySelectorAll('.mobile-menu-bar');
        bars[0].style.transform = '';
        bars[1].style.opacity = '1';
        bars[2].style.transform = '';
    }

    mobileToggle.addEventListener('click', function() {
        const isOpen = mobilePanel.classList.contains('translate-x-0');
        if (isOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });

    mobileClose.addEventListener('click', closeMobileMenu);
    mobileOverlay.addEventListener('click', closeMobileMenu);

    mobileMenu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', closeMobileMenu);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobilePanel.classList.contains('translate-x-0')) {
            closeMobileMenu();
        }
    });

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function(link) {
        link.addEventListener('mouseenter', function() {
            const underline = this.querySelector('.nav-underline');
            if (underline && !this.classList.contains('active')) {
                underline.style.width = '100%';
            }
        });
        link.addEventListener('mouseleave', function() {
            const underline = this.querySelector('.nav-underline');
            if (underline && !underline.classList.contains('!w-full')) {
                underline.style.width = '0';
            }
        });
    });
})();
</script>

<style>
    .mobile-menu-bar {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
</style>
