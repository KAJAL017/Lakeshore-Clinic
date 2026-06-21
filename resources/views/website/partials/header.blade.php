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
                        ['label' => 'Home', 'url' => route('home')],
                        ['label' => 'About', 'url' => route('website.about')],
                        ['label' => 'Medical Center', 'url' => route('website.medical-center')],
                        ['label' => 'MediCORE Pharmacy', 'url' => route('website.pharmacy')],
                        ['label' => 'Wellness Center', 'url' => route('website.wellness')],
                        ['label' => 'Services', 'url' => route('website.services')],
                        ['label' => 'Book Online', 'url' => route('website.book-online')],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $isActive = request()->is(ltrim(parse_url($item['url'], PHP_URL_PATH), '/'));
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
                <a href="{{ route('login') }}" class="flex items-center justify-center w-[45px] h-[45px] rounded-full bg-[#0d4f4f] hover:bg-[#0a3d3d] transition-colors duration-200 shrink-0" aria-label="Account">
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

@include('website.partials.mobile-menu')

<div id="header-spacer" class="h-[95px]"></div>

@push('scripts')
<script src="{{ asset('website/js/navigation.js') }}"></script>
@endpush

<style>
    .mobile-menu-bar {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
</style>
