<header class="bg-white border-b border-slate-200/90 py-4 sm:py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            
            <!-- Left: Brand Masthead & Mobile Menu Trigger -->
            <div class="flex items-center space-x-2.5 sm:space-x-3.5 min-w-0">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="min-w-[44px] min-h-[44px] p-2.5 text-slate-800 hover:text-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-900 rounded-xl bg-slate-100 border border-slate-200 lg:hidden flex items-center justify-center shrink-0 transition"
                        aria-label="Buka Menu Navigasi">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 sm:space-x-3.5 group min-w-0">
                    <!-- Bespoke Emblem / Custom Uploaded Logo -->
                    @if(\App\Models\Setting::get('site_logo'))
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl overflow-hidden border border-slate-200 shadow-sm shrink-0 group-hover:scale-105 transition-transform bg-white p-0.5">
                            <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo {{ \App\Models\Setting::get('site_name', 'Jurnalistik SPELAND') }}" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-slate-950 text-white flex flex-col items-center justify-center border-b-2 border-red-600 shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                            <span class="font-serif font-black text-base sm:text-xl leading-none">JS</span>
                            <span class="text-3xs font-extrabold uppercase tracking-widest text-red-400 scale-75 -mt-0.5">PRESS</span>
                        </div>
                    @endif

                    <!-- Title & Tagline -->
                    <div class="min-w-0">
                        <div class="text-lg sm:text-2xl lg:text-3xl font-black tracking-tight text-slate-950 font-sans group-hover:text-blue-950 transition uppercase leading-none truncate">
                            JURNALISTIK <span class="text-blue-900">SPELAND</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 mt-1">
                            <span class="text-3xs sm:text-2xs font-extrabold uppercase tracking-wider text-red-600 truncate block">
                                SMP Negeri 9 Probolinggo
                            </span>
                            <span class="text-slate-300 hidden md:inline">&bull;</span>
                            <span class="text-3xs sm:text-2xs text-slate-500 font-serif italic hidden md:inline">
                                &ldquo;Mengabarkan Fakta, Menyuarakan Cerita&rdquo;
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Right Utilities (Search Trigger & Live Podcast Button) -->
            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <!-- Search Button with Keyboard Shortcut -->
                <button @click="searchOpen = true" 
                        type="button" 
                        class="flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-700 min-w-[44px] min-h-[44px] p-2.5 sm:px-3.5 sm:py-2 rounded-xl text-xs font-semibold transition border border-slate-200 shadow-2xs group"
                        title="Pencarian Cepat">
                    <i data-lucide="search" class="w-4 h-4 text-slate-500 group-hover:text-blue-900 transition sm:mr-2"></i>
                    <span class="hidden sm:inline">Cari Berita...</span>
                    <kbd class="hidden md:inline-block ml-2.5 px-1.5 py-0.5 bg-white border border-slate-200 text-slate-400 rounded text-3xs font-mono font-bold shadow-2xs">Ctrl K</kbd>
                </button>

                <!-- Podcast Button -->
                <a href="{{ route('multimedia.podcasts') }}" 
                   class="hidden md:inline-flex items-center bg-slate-950 hover:bg-blue-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs border border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                    <i data-lucide="mic" class="w-3.5 h-3.5 mr-1.5 text-red-400"></i>
                    <span>Podcast SPELAND</span>
                </a>
            </div>

        </div>
    </div>
</header>
