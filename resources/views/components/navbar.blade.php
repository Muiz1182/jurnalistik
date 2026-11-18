@php
    $categories = \App\Models\Category::where('is_active', true)
        ->where('show_in_navbar', true)
        ->orderBy('order')
        ->get();
@endphp

<!-- Desktop Navigation Bar -->
<nav class="bg-blue-950 text-white shadow-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hidden lg:flex items-center justify-between">
            <ul class="flex items-center space-x-1 text-sm font-semibold tracking-wide">
                <li>
                    <a href="{{ route('home') }}" 
                       class="inline-block py-3 px-3.5 hover:bg-blue-900 transition {{ request()->routeIs('home') ? 'bg-blue-900 text-white border-b-2 border-red-500' : 'text-slate-200' }}">
                        BERANDA
                    </a>
                </li>
                <li>
                    <a href="{{ route('articles.index') }}" 
                       class="inline-block py-3 px-3.5 hover:bg-blue-900 transition {{ request()->routeIs('articles.index') ? 'bg-blue-900 text-white border-b-2 border-red-500' : 'text-slate-200' }}">
                        SEMUA BERITA
                    </a>
                </li>

                <!-- Dynamic Categories from Database -->
                @foreach($categories as $navCat)
                    <li>
                        <a href="{{ route('articles.category', $navCat->slug) }}" 
                           class="inline-block py-3 px-3 hover:bg-blue-900 transition {{ request()->is('kategori/' . $navCat->slug) ? 'bg-blue-900 text-white border-b-2 border-red-500' : 'text-slate-200' }}">
                            {{ strtoupper($navCat->name) }}
                        </a>
                    </li>
                @endforeach

                <!-- Multimedia Dropdown -->
                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="inline-flex items-center py-3 px-3 hover:bg-blue-900 text-slate-200 transition focus:outline-none">
                        <span>MULTIMEDIA</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1"></i>
                    </button>
                    <div x-show="open" 
                         x-transition
                         class="absolute left-0 mt-0 w-48 bg-white text-slate-800 rounded-b-lg shadow-xl py-2 border border-slate-100 z-50">
                        <a href="{{ route('multimedia.galleries') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Galeri Foto
                        </a>
                        <a href="{{ route('multimedia.videos') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Video Jurnalistik
                        </a>
                        <a href="{{ route('multimedia.podcasts') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Podcast SPELAND
                        </a>
                        <a href="{{ route('multimedia.special-coverages') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900 border-t border-slate-100 mt-1 pt-2 text-blue-900">
                            Liputan Khusus
                        </a>
                    </div>
                </li>

                <!-- Tentang Kami Dropdown -->
                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="inline-flex items-center py-3 px-3 hover:bg-blue-900 text-slate-200 transition focus:outline-none">
                        <span>REDAKSI</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1"></i>
                    </button>
                    <div x-show="open" 
                         x-transition
                         class="absolute right-0 mt-0 w-52 bg-white text-slate-800 rounded-b-lg shadow-xl py-2 border border-slate-100 z-50">
                        <a href="{{ route('about') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Tentang Jurnalistik SPELAND
                        </a>
                        <a href="{{ route('editorial.structure') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Struktur Redaksi
                        </a>
                        <a href="{{ route('editorial.policy') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Kebijakan Redaksi
                        </a>
                        <a href="{{ route('journalistic.guidelines') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            Pedoman Pemberitaan
                        </a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900 border-t border-slate-100 mt-1 pt-2">
                            Kontak Redaksi
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Quick Link to Popular & Latest -->
            <div class="flex items-center space-x-2 text-xs font-semibold">
                <a href="{{ route('articles.popular') }}" class="py-1.5 px-2.5 rounded bg-blue-900 hover:bg-blue-800 text-amber-300 transition flex items-center">
                    <i data-lucide="flame" class="w-3.5 h-3.5 mr-1 text-amber-400"></i>
                    Populer
                </a>
                <a href="{{ route('articles.archive') }}" class="py-1.5 px-2.5 rounded bg-blue-900 hover:bg-blue-800 text-slate-300 transition">
                    Arsip
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Navigation -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         @click.away="mobileMenuOpen = false" 
         class="lg:hidden bg-blue-950 border-t border-blue-900 px-4 pt-3 pb-6 space-y-1">
        
        <div class="pb-3 mb-2 border-b border-blue-900">
            <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block mb-1">Navigasi Utama</span>
            <a href="{{ route('home') }}" class="block py-2 text-sm font-semibold text-white hover:text-blue-300">BERANDA</a>
            <a href="{{ route('articles.index') }}" class="block py-2 text-sm font-semibold text-white hover:text-blue-300">SEMUA BERITA</a>
            <a href="{{ route('articles.popular') }}" class="block py-2 text-sm font-semibold text-amber-300 hover:text-amber-200">BERITA POPULER</a>
            <a href="{{ route('articles.latest') }}" class="block py-2 text-sm font-semibold text-white hover:text-blue-300">BERITA TERBARU</a>
        </div>

        <div class="pb-3 mb-2 border-b border-blue-900">
            <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block mb-1">Kategori Berita</span>
            <div class="grid grid-cols-2 gap-1 text-sm font-medium">
                @foreach($categories as $navCat)
                    <a href="{{ route('articles.category', $navCat->slug) }}" class="py-1.5 text-slate-200 hover:text-white">
                        {{ $navCat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="pb-3 mb-2 border-b border-blue-900">
            <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block mb-1">Multimedia</span>
            <div class="grid grid-cols-2 gap-1 text-sm font-medium">
                <a href="{{ route('multimedia.galleries') }}" class="py-1.5 text-slate-200 hover:text-white">Galeri Foto</a>
                <a href="{{ route('multimedia.videos') }}" class="py-1.5 text-slate-200 hover:text-white">Video Jurnalistik</a>
                <a href="{{ route('multimedia.podcasts') }}" class="py-1.5 text-slate-200 hover:text-white">Podcast SPELAND</a>
                <a href="{{ route('multimedia.special-coverages') }}" class="py-1.5 text-blue-300 hover:text-blue-200 font-semibold">Liputan Khusus</a>
            </div>
        </div>

        <div>
            <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block mb-1">Tentang Media</span>
            <div class="grid grid-cols-2 gap-1 text-sm font-medium">
                <a href="{{ route('about') }}" class="py-1.5 text-slate-200 hover:text-white">Profil SPELAND</a>
                <a href="{{ route('editorial.structure') }}" class="py-1.5 text-slate-200 hover:text-white">Struktur Redaksi</a>
                <a href="{{ route('editorial.policy') }}" class="py-1.5 text-slate-200 hover:text-white">Kebijakan Redaksi</a>
                <a href="{{ route('contact') }}" class="py-1.5 text-slate-200 hover:text-white">Kontak Kami</a>
            </div>
        </div>
    </div>
</nav>
