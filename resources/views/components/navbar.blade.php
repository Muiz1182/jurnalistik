@php
    $allCategories = \App\Models\Category::where('is_active', true)
        ->orderBy('order')
        ->get();

    // Primary rubrics shown directly on the desktop navbar
    $primarySlugs = ['pendidikan', 'prestasi', 'kegiatan', 'opini'];
    $primaryCategories = $allCategories->filter(function($c) use ($primarySlugs) {
        return in_array($c->slug, $primarySlugs);
    });

    // Fallback if less than 4
    if ($primaryCategories->count() < 4) {
        $primaryCategories = $allCategories->take(4);
    }

    // Other categories in the "Rubrik Lainnya" dropdown
    $otherCategories = $allCategories->filter(function($c) use ($primaryCategories) {
        return !$primaryCategories->contains('id', $c->id);
    });

    // Short display label helper
    $shortLabels = [
        'kegiatan' => 'KEGIATAN',
        'pendidikan' => 'PENDIDIKAN',
        'prestasi' => 'PRESTASI',
        'opini' => 'OPINI',
        'lingkungan' => 'LINGKUNGAN',
        'sekolah' => 'SEKOLAH',
    ];
@endphp

<!-- Desktop Navigation Bar -->
<nav class="bg-slate-950 text-white shadow-md sticky top-0 z-40 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hidden lg:flex items-center justify-between whitespace-nowrap">
            
            <!-- Left Main Category Links -->
            <ul class="flex items-center space-x-1 text-xs font-bold tracking-wide">
                <li>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center py-3.5 px-3.5 transition {{ request()->routeIs('home') ? 'bg-slate-900 text-white border-b-2 border-red-500 font-extrabold' : 'text-slate-200 hover:bg-slate-900 hover:text-white' }}">
                        <i data-lucide="home" class="w-3.5 h-3.5 mr-1.5 opacity-90 text-blue-400"></i>
                        <span>BERANDA</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('articles.index') }}" 
                       class="inline-block py-3.5 px-3.5 transition {{ request()->routeIs('articles.index') ? 'bg-slate-900 text-white border-b-2 border-red-500 font-extrabold' : 'text-slate-200 hover:bg-slate-900 hover:text-white' }}">
                        SEMUA BERITA
                    </a>
                </li>

                <!-- Primary Categories -->
                @foreach($primaryCategories as $navCat)
                    <li>
                        <a href="{{ route('articles.category', $navCat->slug) }}" 
                           class="inline-block py-3.5 px-3.5 transition {{ request()->is('kategori/' . $navCat->slug) || request()->is('berita/kategori/' . $navCat->slug) ? 'bg-slate-900 text-white border-b-2 border-red-500 font-extrabold' : 'text-slate-200 hover:bg-slate-900 hover:text-white' }}">
                            {{ $shortLabels[$navCat->slug] ?? strtoupper($navCat->name) }}
                        </a>
                    </li>
                @endforeach

                <!-- More Categories Dropdown -->
                @if($otherCategories->isNotEmpty())
                    <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="inline-flex items-center py-3.5 px-3.5 hover:bg-slate-900 text-slate-200 transition focus:outline-none font-bold">
                            <span>RUBRIK LAINNYA</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 opacity-70"></i>
                        </button>
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-0 mt-0 w-64 bg-slate-900 text-slate-200 rounded-b-xl shadow-2xl py-2 border border-slate-800 z-50 divide-y divide-slate-800/80">
                            <div class="py-1">
                                @foreach($otherCategories as $otherCat)
                                    <a href="{{ route('articles.category', $otherCat->slug) }}" class="flex items-center justify-between px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 rounded-full mr-2.5" style="background-color: {{ $otherCat->color ?: '#3B82F6' }}"></span>
                                            <span>{{ $otherCat->name }}</span>
                                        </span>
                                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-500"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endif

                <!-- Multimedia Dropdown -->
                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="inline-flex items-center py-3.5 px-3.5 hover:bg-slate-900 text-slate-200 transition focus:outline-none font-bold">
                        <span>MULTIMEDIA</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 opacity-70"></i>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 mt-0 w-64 bg-slate-900 text-slate-200 rounded-b-xl shadow-2xl py-2 border border-slate-800 z-50 divide-y divide-slate-800/80">
                        <div class="py-1">
                            <a href="{{ route('multimedia.galleries') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="camera" class="w-4 h-4 mr-2.5 text-blue-400"></i>
                                <span>Galeri Foto</span>
                            </a>
                            <a href="{{ route('multimedia.videos') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="video" class="w-4 h-4 mr-2.5 text-red-400"></i>
                                <span>Video Jurnalistik</span>
                            </a>
                            <a href="{{ route('multimedia.podcasts') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="mic" class="w-4 h-4 mr-2.5 text-purple-400"></i>
                                <span>Podcast SPELAND</span>
                            </a>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('multimedia.special-coverages') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="bookmark-check" class="w-4 h-4 mr-2.5 text-amber-400"></i>
                                <span>Liputan Khusus</span>
                            </a>
                        </div>
                    </div>
                </li>

                <!-- Tentang Redaksi Dropdown -->
                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="inline-flex items-center py-3.5 px-3.5 hover:bg-slate-900 text-slate-200 transition focus:outline-none font-bold">
                        <span>REDAKSI</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 opacity-70"></i>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-0 w-72 bg-slate-900 text-slate-200 rounded-b-xl shadow-2xl py-2 border border-slate-800 z-50 divide-y divide-slate-800/80">
                        <div class="py-1">
                            <a href="{{ route('about') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="info" class="w-4 h-4 mr-2.5 text-blue-400 shrink-0"></i>
                                <span>Tentang Jurnalistik SPELAND</span>
                            </a>
                            <a href="{{ route('editorial.structure') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="users" class="w-4 h-4 mr-2.5 text-teal-400 shrink-0"></i>
                                <span>Struktur Dewan Redaksi</span>
                            </a>
                            <a href="{{ route('editorial.policy') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="shield" class="w-4 h-4 mr-2.5 text-amber-400 shrink-0"></i>
                                <span>Kebijakan Redaksi</span>
                            </a>
                            <a href="{{ route('journalistic.guidelines') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="heart-handshake" class="w-4 h-4 mr-2.5 text-pink-400 shrink-0"></i>
                                <span class="truncate">Pedoman Ramah Anak</span>
                            </a>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('contact') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold hover:bg-slate-800 hover:text-white transition">
                                <i data-lucide="mail" class="w-4 h-4 mr-2.5 text-emerald-400 shrink-0"></i>
                                <span>Kontak & Hak Jawab</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- Right Fast-Nav Pills -->
            <div class="flex items-center space-x-2 text-2xs font-bold">
                <a href="{{ route('articles.popular') }}" 
                   class="py-1.5 px-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 hover:text-amber-300 transition flex items-center shadow-xs border border-slate-800"
                   title="Berita Terpopuler">
                    <i data-lucide="flame" class="w-3.5 h-3.5 mr-1 text-amber-400"></i>
                    <span>Populer</span>
                </a>
                <a href="{{ route('articles.archive') }}" 
                   class="py-1.5 px-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white transition flex items-center border border-slate-800"
                   title="Arsip Berita">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                    <span>Arsip</span>
                </a>
            </div>

        </div>
    </div>
</nav>

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
                    @if(\App\Models\Setting::get('site_logo'))
                        <div class="w-9 h-9 rounded-lg overflow-hidden bg-white p-0.5 border border-slate-700 shrink-0">
                            <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-9 h-9 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                            JS
                        </div>
                    @endif
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

                <div class="pt-3 border-t border-slate-100">
                    <span class="text-3xs uppercase tracking-wider text-slate-400 font-extrabold block px-3 mb-2">Kanal Resmi:</span>
                    <div class="flex items-center space-x-2 px-3">
                        <a href="{{ \App\Models\Setting::get('social_tiktok', \App\Models\Setting::get('social_facebook', '#')) }}" target="_blank" rel="noopener" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="TikTok">
                            <svg class="w-4 h-4 fill-current text-slate-900" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.27 6.27 0 0 0 1.9-4.49V8.75a8.16 8.16 0 0 0 4.87 1.58V6.89c-.338-.002-.676-.07-1-.2z"/>
                            </svg>
                        </a>
                        <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" rel="noopener" class="p-2 rounded-lg bg-pink-50 hover:bg-pink-100 text-pink-600 transition" title="Instagram">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" target="_blank" rel="noopener" class="p-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="YouTube">
                            <svg class="w-4 h-4 fill-current text-red-600" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
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
