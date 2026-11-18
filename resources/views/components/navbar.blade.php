@php
    $allCategories = \App\Models\Category::where('is_active', true)
        ->orderBy('order')
        ->get();

    // Primary categories to show directly on the main bar
    $primarySlugs = ['pendidikan', 'prestasi', 'kegiatan', 'adiwiyata-lingkungan', 'lingkungan', 'opini'];
    $primaryCategories = $allCategories->filter(function($c) use ($primarySlugs) {
        return in_array($c->slug, $primarySlugs) || $c->order <= 5;
    })->take(5);

    // Other categories in the "Kanal Lainnya" dropdown
    $otherCategories = $allCategories->filter(function($c) use ($primaryCategories) {
        return !$primaryCategories->contains('id', $c->id);
    });
@endphp

<!-- Desktop Navigation Bar -->
<nav class="bg-blue-950 text-white shadow-md sticky top-0 z-40 border-b border-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hidden lg:flex items-center justify-between">
            
            <!-- Left Main Category Links -->
            <ul class="flex items-center space-x-0.5 text-xs font-bold tracking-wide">
                <li>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center py-3 px-3.5 hover:bg-blue-900/80 transition {{ request()->routeIs('home') ? 'bg-blue-900 text-white border-b-2 border-red-500' : 'text-slate-200' }}">
                        <i data-lucide="home" class="w-3.5 h-3.5 mr-1.5 opacity-80"></i>
                        <span>BERANDA</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('articles.index') }}" 
                       class="inline-block py-3 px-3.5 hover:bg-blue-900/80 transition {{ request()->routeIs('articles.index') ? 'bg-blue-900 text-white border-b-2 border-red-500' : 'text-slate-200' }}">
                        SEMUA BERITA
                    </a>
                </li>

                <!-- Primary Categories -->
                @foreach($primaryCategories as $navCat)
                    <li>
                        <a href="{{ route('articles.category', $navCat->slug) }}" 
                           class="inline-block py-3 px-3 hover:bg-blue-900/80 transition {{ request()->is('kategori/' . $navCat->slug) || request()->is('berita/kategori/' . $navCat->slug) ? 'bg-blue-900 text-white border-b-2 border-red-500' : 'text-slate-200' }}">
                            {{ strtoupper($navCat->name) }}
                        </a>
                    </li>
                @endforeach

                <!-- More Categories Dropdown -->
                @if($otherCategories->isNotEmpty())
                    <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="inline-flex items-center py-3 px-3 hover:bg-blue-900/80 text-slate-200 transition focus:outline-none font-bold">
                            <span>RUBRIK LAINNYA</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 opacity-70"></i>
                        </button>
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-0 mt-0 w-56 bg-white text-slate-800 rounded-b-xl shadow-2xl py-2 border border-slate-100 z-50 divide-y divide-slate-100">
                            <div class="py-1">
                                @foreach($otherCategories as $otherCat)
                                    <a href="{{ route('articles.category', $otherCat->slug) }}" class="flex items-center justify-between px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900 transition">
                                        <span>{{ $otherCat->name }}</span>
                                        <span class="text-3xs text-slate-400 font-mono">{{ $otherCat->articles_count ?? '' }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endif

                <!-- Multimedia Dropdown -->
                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="inline-flex items-center py-3 px-3 hover:bg-blue-900/80 text-slate-200 transition focus:outline-none font-bold">
                        <span>MULTIMEDIA</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 opacity-70"></i>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 mt-0 w-52 bg-white text-slate-800 rounded-b-xl shadow-2xl py-2 border border-slate-100 z-50">
                        <a href="{{ route('multimedia.galleries') }}" class="flex items-center px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            <i data-lucide="camera" class="w-3.5 h-3.5 mr-2 text-blue-900"></i>
                            <span>Galeri Foto</span>
                        </a>
                        <a href="{{ route('multimedia.videos') }}" class="flex items-center px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            <i data-lucide="video" class="w-3.5 h-3.5 mr-2 text-red-600"></i>
                            <span>Video Jurnalistik</span>
                        </a>
                        <a href="{{ route('multimedia.podcasts') }}" class="flex items-center px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900">
                            <i data-lucide="mic" class="w-3.5 h-3.5 mr-2 text-purple-600"></i>
                            <span>Podcast SPELAND</span>
                        </a>
                        <a href="{{ route('multimedia.special-coverages') }}" class="flex items-center px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900 border-t border-slate-100 mt-1 pt-2">
                            <i data-lucide="bookmark-check" class="w-3.5 h-3.5 mr-2 text-amber-600"></i>
                            <span>Liputan Khusus</span>
                        </a>
                    </div>
                </li>

                <!-- Tentang Redaksi Dropdown -->
                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="inline-flex items-center py-3 px-3 hover:bg-blue-900/80 text-slate-200 transition focus:outline-none font-bold">
                        <span>REDAKSI</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 opacity-70"></i>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-0 w-56 bg-white text-slate-800 rounded-b-xl shadow-2xl py-2 border border-slate-100 z-50">
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
                            Pedoman Pemberitaan Ramah Anak
                        </a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-slate-50 hover:text-blue-900 border-t border-slate-100 mt-1 pt-2">
                            Kontak & Hak Jawab
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Right Fast-Nav Pills -->
            <div class="flex items-center space-x-2 text-2xs font-bold">
                <a href="{{ route('articles.popular') }}" class="py-1.5 px-3 rounded-lg bg-blue-900/90 hover:bg-amber-500 hover:text-slate-950 text-amber-300 transition flex items-center shadow-xs">
                    <i data-lucide="flame" class="w-3.5 h-3.5 mr-1 text-amber-400"></i>
                    <span>Populer</span>
                </a>
                <a href="{{ route('articles.archive') }}" class="py-1.5 px-3 rounded-lg bg-blue-900/70 hover:bg-blue-800 text-slate-300 transition flex items-center">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                    <span>Arsip</span>
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- Mobile Navigation Drawer -->
<div x-show="mobileMenuOpen" 
     x-cloak
     class="fixed inset-0 z-50 lg:hidden overflow-hidden bg-slate-950/70 backdrop-blur-xs flex"
     x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div @click.away="mobileMenuOpen = false" 
         class="w-80 max-w-full bg-white h-full shadow-2xl flex flex-col justify-between overflow-y-auto"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full">
        
        <div>
            <!-- Mobile Drawer Header -->
            <div class="p-5 bg-blue-950 text-white flex items-center justify-between border-b border-blue-900">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold text-sm">
                        JS
                    </div>
                    <div>
                        <span class="font-extrabold text-sm block leading-tight">JURNALISTIK SPELAND</span>
                        <span class="text-3xs text-slate-300 block">SMP Negeri 9 Probolinggo</span>
                    </div>
                </div>
                <button @click="mobileMenuOpen = false" class="text-slate-300 hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Drawer Navigation Items -->
            <div class="p-4 space-y-4 text-xs font-bold text-slate-800">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-950' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('articles.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">
                        Semua Berita
                    </a>
                    <a href="{{ route('articles.popular') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100 text-amber-700">
                        Berita Populer 🔥
                    </a>
                    <a href="{{ route('articles.latest') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">
                        Berita Terbaru
                    </a>
                    <a href="{{ route('articles.opinion') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">
                        Opini & Esai Murid
                    </a>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <span class="text-3xs uppercase tracking-wider text-slate-400 font-extrabold block px-3 mb-2">Rubrik Liputan:</span>
                    <div class="space-y-0.5">
                        @foreach($allCategories as $cat)
                            <a href="{{ route('articles.category', $cat->slug) }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <span class="text-3xs uppercase tracking-wider text-slate-400 font-extrabold block px-3 mb-2">Multimedia:</span>
                    <div class="space-y-0.5">
                        <a href="{{ route('multimedia.galleries') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Galeri Foto</a>
                        <a href="{{ route('multimedia.videos') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Video Jurnalistik</a>
                        <a href="{{ route('multimedia.podcasts') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Podcast SPELAND</a>
                        <a href="{{ route('multimedia.special-coverages') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Liputan Khusus</a>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <span class="text-3xs uppercase tracking-wider text-slate-400 font-extrabold block px-3 mb-2">Redaksi:</span>
                    <div class="space-y-0.5">
                        <a href="{{ route('about') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Tentang Kami</a>
                        <a href="{{ route('editorial.structure') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Struktur Redaksi</a>
                        <a href="{{ route('editorial.policy') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Kebijakan Redaksi</a>
                        <a href="{{ route('journalistic.guidelines') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Pedoman Pemberitaan</a>
                        <a href="{{ route('contact') }}" class="block px-3 py-1.5 rounded-md hover:bg-slate-100 text-slate-700">Kontak & Hak Jawab</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Drawer Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-200">
            @auth
                <div class="flex items-center justify-between text-xs">
                    <span class="font-bold text-slate-900 truncate">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->canAccessDashboard())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-1 bg-blue-950 text-white rounded text-2xs font-bold">Meja Redaksi</a>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 text-center text-xs font-bold">
                    <a href="{{ route('login') }}" class="py-2 bg-slate-200 text-slate-800 rounded-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="py-2 bg-blue-950 text-white rounded-lg">Daftar</a>
                </div>
            @endauth
        </div>

    </div>
</div>
