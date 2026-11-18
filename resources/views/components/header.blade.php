<header class="bg-white border-b border-slate-200/90 py-5 sm:py-7">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            
            <!-- Mobile Menu Trigger -->
            <div class="flex items-center lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="p-2 text-slate-800 hover:text-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-900 rounded-lg bg-slate-50 border border-slate-200"
                        aria-label="Buka Menu Navigasi">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Brand Masthead -->
            <div class="flex items-center space-x-3.5 sm:space-x-4">
                <!-- Bespoke Emblem -->
                <a href="{{ route('home') }}" class="shrink-0 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 text-white flex flex-col items-center justify-center shadow-md border-b-2 border-red-600 group-hover:scale-105 transition-transform duration-300">
                        <span class="font-serif font-black text-xl sm:text-2xl tracking-tighter leading-none">JS</span>
                        <span class="text-2xs font-extrabold uppercase tracking-widest text-red-400 scale-75 -mt-0.5">PRESS</span>
                    </div>
                </a>

                <!-- Title & Tagline -->
                <div>
                    <a href="{{ route('home') }}" class="group block">
                        <div class="flex items-baseline space-x-2">
                            <span class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-slate-950 group-hover:text-blue-950 transition font-sans">
                                JURNALISTIK <span class="text-blue-900 font-extrabold">SPELAND</span>
                            </span>
                        </div>
                    </a>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 mt-0.5">
                        <span class="text-2xs sm:text-xs font-bold uppercase tracking-wider text-red-600">
                            Portal Berita Resmi SMP Negeri 9 Probolinggo
                        </span>
                        <span class="hidden md:inline text-slate-300">&bull;</span>
                        <span class="hidden md:inline text-2xs sm:text-xs text-slate-500 font-medium italic font-serif">
                            &ldquo;Mengabarkan Fakta, Menyuarakan Cerita.&rdquo;
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Utilities (Search Trigger & Live Podcast / Editorial CTA) -->
            <div class="flex items-center space-x-2.5 sm:space-x-3 shrink-0">
                <!-- Search Button with Keyboard Shortcut -->
                <button @click="searchOpen = true" 
                        type="button" 
                        class="flex items-center bg-slate-50 hover:bg-slate-100 text-slate-700 px-3.5 py-2 rounded-xl text-xs font-semibold transition border border-slate-200/90 shadow-2xs group">
                    <i data-lucide="search" class="w-4 h-4 mr-2 text-slate-400 group-hover:text-blue-900 transition"></i>
                    <span class="hidden sm:inline">Cari Berita...</span>
                    <kbd class="hidden md:inline-block ml-3 px-1.5 py-0.5 bg-white border border-slate-200 text-slate-400 rounded text-3xs font-mono font-bold shadow-2xs">Ctrl K</kbd>
                </button>

                <!-- Podcast Button -->
                <a href="{{ route('multimedia.podcasts') }}" 
                   class="hidden md:inline-flex items-center bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                    <i data-lucide="mic" class="w-3.5 h-3.5 mr-1.5 text-red-400"></i>
                    <span>Podcast SPELAND</span>
                </a>
            </div>

        </div>
    </div>
</header>
