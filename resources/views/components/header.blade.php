<header class="bg-white border-b border-slate-200 py-4 sm:py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        
        <!-- Mobile Menu Toggle Button -->
        <div class="flex items-center lg:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="p-2 -ml-2 text-slate-700 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-900 rounded-md"
                    aria-label="Buka Menu Navigasi">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Main Masthead Brand / Logo -->
        <div class="flex flex-col items-center mx-auto lg:items-start lg:mx-0 text-center lg:text-left">
            <a href="{{ route('home') }}" class="group block">
                <div class="flex items-center gap-3">
                    <!-- Brand Icon Emblem -->
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-950 text-white rounded-lg flex items-center justify-center font-extrabold text-xl shadow-md border-b-2 border-red-600 group-hover:bg-blue-900 transition">
                        JS
                    </div>
                    <div>
                        <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-blue-950 block leading-none">
                            JURNALISTIK <span class="text-blue-700">SPELAND</span>
                        </span>
                        <span class="text-xs sm:text-xs font-semibold tracking-wider uppercase text-red-600 mt-1 block">
                            Portal Berita Resmi SMP Negeri 9 Probolinggo
                        </span>
                    </div>
                </div>
            </a>
            <p class="hidden sm:block text-xs text-slate-500 mt-1.5 font-medium italic">
                &ldquo;Mengabarkan Fakta, Menyuarakan Cerita.&rdquo;
            </p>
        </div>

        <!-- Right Header Actions (Search & Quick Action) -->
        <div class="flex items-center space-x-3">
            <button @click="searchOpen = true" 
                    type="button" 
                    class="flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-3.5 py-2 rounded-lg text-xs font-medium transition border border-slate-200">
                <i data-lucide="search" class="w-4 h-4 sm:mr-2 text-slate-500"></i>
                <span class="hidden sm:inline">Pencarian Berita</span>
            </button>

            <a href="{{ route('multimedia.podcasts') }}" 
               class="hidden md:inline-flex items-center bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition shadow-sm">
                <i data-lucide="mic" class="w-3.5 h-3.5 mr-1.5 text-red-400"></i>
                Podcast SPELAND
            </a>
        </div>
    </div>
</header>
