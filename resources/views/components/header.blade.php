<header class="bg-white border-b-2 border-slate-900/90 py-5 sm:py-6 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Editorial Row -->
        <div class="flex items-center justify-between gap-4">
            
            <!-- Left Info / Mobile Menu Trigger -->
            <div class="flex items-center space-x-3">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="p-2 text-slate-800 hover:text-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-900 rounded-lg bg-slate-100 border border-slate-200 lg:hidden"
                        aria-label="Buka Menu Navigasi">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <!-- Hidden on mobile, prominent on desktop: Editorial Stamp -->
                <div class="hidden lg:flex flex-col text-left border-l-2 border-slate-900 pl-3">
                    <span class="text-3xs uppercase tracking-widest font-black text-slate-900">PERS PELAJAR RESMI</span>
                    <span class="text-2xs text-slate-500 font-medium font-serif italic">Independen, Edukatif & Beretika</span>
                </div>
            </div>

            <!-- Central Editorial Masthead -->
            <div class="text-center flex-1 max-w-2xl px-2">
                <a href="{{ route('home') }}" class="inline-block group">
                    <div class="flex items-center justify-center space-x-2.5 sm:space-x-3 mb-1">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-slate-950 text-white flex items-center justify-center font-serif font-black text-lg sm:text-xl border-b-2 border-red-600 shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                            JS
                        </div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-slate-950 font-sans group-hover:text-blue-950 transition uppercase">
                            JURNALISTIK <span class="text-blue-900">SPELAND</span>
                        </h1>
                    </div>
                </a>
                
                <div class="flex items-center justify-center space-x-2 text-2xs sm:text-xs">
                    <span class="font-extrabold uppercase tracking-wider text-red-600">
                        SMP NEGERI 9 PROBOLINGGO
                    </span>
                    <span class="text-slate-300 font-serif">&bull;</span>
                    <span class="text-slate-600 font-serif italic hidden sm:inline">
                        &ldquo;Mengabarkan Fakta, Menyuarakan Cerita&rdquo;
                    </span>
                </div>
            </div>

            <!-- Right Utilities (Search Trigger & Live Podcast / Editorial CTA) -->
            <div class="flex items-center space-x-2.5 sm:space-x-3 shrink-0">
                <!-- Search Button with Keyboard Shortcut -->
                <button @click="searchOpen = true" 
                        type="button" 
                        class="flex items-center bg-slate-50 hover:bg-slate-100 text-slate-700 px-3.5 py-2 rounded-xl text-xs font-semibold transition border border-slate-200 shadow-2xs group"
                        title="Pencarian Cepat">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 group-hover:text-blue-900 transition sm:mr-2"></i>
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
