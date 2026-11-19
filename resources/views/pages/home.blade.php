@extends('layouts.app')

@section('title', 'JURNALISTIK SPELAND | Portal Berita Digital Resmi SMP Negeri 9 Probolinggo')
@section('meta_description', 'Portal berita dan publikasi jurnalistik resmi SMP Negeri 9 Probolinggo. Mengabarkan fakta kegiatan, prestasi, adiwiyata, dan karya literasi murid.')

@section('content')
<div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8 py-4 sm:py-8 space-y-8 sm:space-y-12">

    <!-- 1. HERO FRONT-PAGE SHOWCASE -->
    <section class="border-b border-slate-200/80 pb-10">
        @if($heroHeadline)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Lead Hero Headline (8 Columns) -->
                <div class="lg:col-span-8 group">
                    <article class="flex flex-col">
                        <!-- Dominant Media Container -->
                        <div class="relative aspect-[16/9] w-full overflow-hidden rounded-2xl bg-slate-900 shadow-sm mb-5">
                            <a href="{{ route('articles.show', $heroHeadline->slug) }}" class="block w-full h-full">
                                <img src="{{ $heroHeadline->featured_image_url }}" 
                                     alt="{{ $heroHeadline->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-102 transition duration-500 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                            </a>
                            
                            <!-- Badges (Non-overlapping, Crisp) -->
                            <div class="absolute top-4 left-4 flex flex-wrap items-center gap-2 z-10">
                                <a href="{{ route('articles.category', $heroHeadline->category->slug) }}" 
                                   class="bg-blue-950/95 hover:bg-blue-900 backdrop-blur-md text-white text-xs font-black uppercase px-3 py-1.5 rounded-lg tracking-wider shadow-sm transition">
                                    {{ $heroHeadline->category->name }}
                                </a>
                                @if($heroHeadline->is_breaking)
                                    <span class="bg-red-600 text-white text-xs font-black uppercase px-2.5 py-1.5 rounded-lg shadow-sm flex items-center">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-ping"></span>
                                        BREAKING
                                    </span>
                                @endif
                            </div>

                            @if($heroHeadline->image_caption)
                                <div class="absolute bottom-3 left-4 right-4 z-10 hidden sm:block">
                                    <p class="text-2xs text-slate-300/90 line-clamp-1 italic font-sans bg-slate-950/60 backdrop-blur-xs px-2.5 py-1 rounded inline-block">
                                        Foto: {{ $heroHeadline->image_caption }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Headline Typography & Details -->
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center text-xs text-slate-500 gap-x-3 gap-y-1 font-medium">
                                <span class="inline-flex items-center text-slate-900 font-bold">
                                    <i data-lucide="pen-tool" class="w-3.5 h-3.5 mr-1 text-blue-900"></i>
                                    {{ $heroHeadline->author->name }}
                                </span>
                                <span>&bull;</span>
                                <span class="text-slate-600">{{ $heroHeadline->published_at ? $heroHeadline->published_at->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : 'Baru' }}</span>
                                <span>&bull;</span>
                                <span class="inline-flex items-center text-slate-500 font-semibold">
                                    <i data-lucide="eye" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                                    {{ number_format($heroHeadline->views_count) }} pembaca
                                </span>
                            </div>

                            <h1 class="font-serif font-bold text-2xl sm:text-3xl lg:text-4xl text-slate-950 group-hover:text-blue-950 transition leading-tight tracking-tight">
                                <a href="{{ route('articles.show', $heroHeadline->slug) }}">
                                    {{ $heroHeadline->title }}
                                </a>
                            </h1>

                            @if($heroHeadline->subtitle)
                                <h2 class="text-base sm:text-lg text-slate-600 font-medium leading-snug">
                                    {{ $heroHeadline->subtitle }}
                                </h2>
                            @endif

                            @if($heroHeadline->excerpt)
                                <p class="text-sm sm:text-base text-slate-700 leading-relaxed line-clamp-3 font-normal pt-1">
                                    {{ $heroHeadline->excerpt }}
                                </p>
                            @endif

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('articles.show', $heroHeadline->slug) }}" 
                                   class="inline-flex items-center text-xs sm:text-sm font-bold text-blue-950 hover:text-blue-800 transition group/link">
                                    <span>Baca Berita Selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5 group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                                <span class="text-2xs text-slate-400 font-semibold bg-slate-100 px-2.5 py-1 rounded-md">
                                    ~{{ $heroHeadline->reading_time }} menit baca
                                </span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sorotan Redaksi (4 Columns Sidebar) -->
                <div class="lg:col-span-4 space-y-5">
                    <div class="bg-slate-50/90 border border-slate-200/90 rounded-2xl p-5 shadow-2xs">
                        
                        <div class="flex items-center justify-between pb-3.5 border-b-2 border-blue-950 mb-4">
                            <h2 class="font-black text-xs uppercase tracking-wider text-slate-950 flex items-center">
                                <span class="w-2.5 h-2.5 bg-blue-900 rounded-sm mr-2"></span>
                                Sorotan Redaksi
                            </h2>
                            <span class="text-3xs uppercase tracking-widest font-bold text-slate-400">PILIHAN EDITOR</span>
                        </div>

                        <div class="space-y-4 divide-y divide-slate-200/70">
                            @forelse($secondaryHeadlines as $secondary)
                                <article class="group pt-4 first:pt-0">
                                    <div class="flex gap-3.5 items-start">
                                        <a href="{{ route('articles.show', $secondary->slug) }}" class="w-24 sm:w-28 h-20 shrink-0 overflow-hidden rounded-xl bg-slate-200 block shadow-2xs">
                                            <img src="{{ $secondary->featured_image_url }}" 
                                                 alt="{{ $secondary->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        </a>

                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('articles.category', $secondary->category->slug) }}" 
                                               class="text-3xs font-extrabold text-blue-900 hover:text-red-600 uppercase tracking-wider block mb-1">
                                                {{ $secondary->category->name }}
                                            </a>
                                            <h3 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-blue-950 transition leading-snug line-clamp-2">
                                                <a href="{{ route('articles.show', $secondary->slug) }}">
                                                    {{ $secondary->title }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center text-3xs text-slate-400 mt-1.5 space-x-1.5">
                                                <span>{{ $secondary->author->name }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $secondary->published_at ? $secondary->published_at->locale('id')->diffForHumans() : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="py-6 text-center text-xs text-slate-400">
                                    <p>Belum ada sorotan berita tambahan.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <!-- Editorial Hotline & Whistleblower Box -->
                    <div class="bg-gradient-to-br from-blue-950 to-slate-900 text-white p-5 rounded-2xl shadow-sm space-y-2.5">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="radio" class="w-4 h-4 text-red-400 animate-pulse"></i>
                            <span class="text-2xs font-extrabold uppercase tracking-wider text-slate-300">Kanal Liputan Murid</span>
                        </div>
                        <h4 class="font-serif font-bold text-sm text-white leading-snug">
                            Punya Info Kegiatan atau Prestasi Sekolah?
                        </h4>
                        <p class="text-2xs text-slate-300 leading-relaxed font-sans">
                            Kirimkan ide liputan, rilis kegiatan kelas, atau karya esai Anda kepada meja redaksi Jurnalistik SPELAND.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center text-xs font-bold text-amber-300 hover:text-white transition pt-1">
                            <span>Hubungi Meja Redaksi</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        @else
            <!-- Editorial Newspaper Showcase (When No Articles Published Yet) -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs relative">
                <!-- Top Editorial Eyebrow -->
                <div class="border-b border-slate-200/80 pb-3.5 mb-6 flex flex-wrap items-center justify-between gap-2 text-2xs uppercase tracking-widest font-bold text-slate-900">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                        <span class="font-extrabold text-red-600">EDISI PERDANA RESMI</span>
                        <span class="text-slate-300">&bull;</span>
                        <span class="text-slate-600 font-semibold">PORTAL PERS DIGITAL SEKOLAH</span>
                    </div>
                    <div class="text-slate-500 font-mono text-3xs">
                        KOTA PROBOLINGGO &bull; JAWA TIMUR
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Editorial Letter & Mission (7 cols) -->
                    <div class="lg:col-span-7 space-y-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-950 text-white text-3xs font-black uppercase tracking-wider">
                            PENGANTAR REDAKSI
                        </span>
                        
                        <h1 class="font-serif font-black text-2xl sm:text-3xl text-slate-950 leading-snug tracking-tight">
                            Mengabarkan Fakta Terverifikasi, Menyuarakan Inspirasi Warga Sekolah
                        </h1>

                        <p class="font-serif italic text-sm sm:text-base text-slate-700 leading-snug border-l-3 border-red-600 pl-3.5 py-1">
                            &ldquo;Pers pelajar yang beretika, independen, dan berpihak pada nilai karakter budi pekerti serta prestasi murid.&rdquo;
                        </p>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-sans">
                            Selamat datang di portal berita resmi <strong>Jurnalistik SPELAND (SMP Negeri 9 Probolinggo)</strong>. Platform ini merupakan sistem manajemen redaksi dan media publikasi digital bertaraf profesional tempat seluruh karya jurnalistik, liputan dinamika sekolah, karya literasi, prestasi, dan kegiatan kesiswaan dihimpun serta disebarluaskan kepada masyarakat.
                        </p>

                        <div class="pt-3 flex flex-wrap items-center gap-2.5">
                            @auth
                                <a href="{{ route('admin.articles.create') }}" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition shadow-xs flex items-center">
                                    <i data-lucide="plus-circle" class="w-4 h-4 mr-1.5"></i>
                                    <span>Tulis Naskah Berita</span>
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 bg-slate-950 hover:bg-blue-950 text-white font-bold text-xs rounded-xl transition shadow-xs flex items-center">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 mr-1.5"></i>
                                    <span>Meja Redaksi</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition shadow-xs flex items-center">
                                    <i data-lucide="lock" class="w-4 h-4 mr-1.5"></i>
                                    <span>Masuk Meja Redaksi</span>
                                </a>
                                <a href="{{ route('editorial.structure') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-900 font-bold text-xs rounded-xl transition flex items-center border border-slate-200">
                                    <i data-lucide="users" class="w-4 h-4 mr-1.5 text-slate-600"></i>
                                    <span>Struktur Redaksi</span>
                                </a>
                            @endauth
                            <a href="{{ route('journalistic.guidelines') }}" class="px-3 py-2 text-slate-600 hover:text-blue-950 font-bold text-xs transition flex items-center">
                                <span>Pedoman Ramah Anak &rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Rubrics Directory & Pillars (5 cols) -->
                    @php
                        $officialCategories = $navCategories ?? \App\Models\Category::where('is_active', true)->orderBy('order')->get();
                    @endphp
                    <div class="lg:col-span-5 bg-slate-50 border border-slate-200/90 rounded-2xl p-5 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                            <span class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center">
                                <i data-lucide="compass" class="w-4 h-4 mr-1.5 text-blue-900"></i>
                                Rubrikasi Peliputan
                            </span>
                            <span class="text-3xs text-slate-500 font-semibold font-mono">{{ $officialCategories->count() }} Rubrik</span>
                        </div>

                        <!-- Balanced Grid: 8 items in 2 cols + 1 full-width item -->
                        <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
                            @foreach($officialCategories as $index => $rubrik)
                                <a href="{{ route('articles.category', $rubrik->slug) }}" 
                                   class="flex items-center space-x-2 p-2 rounded-lg bg-white border border-slate-200/80 hover:border-blue-900 hover:bg-blue-50/50 transition group {{ $loop->last && $loop->count % 2 !== 0 ? 'col-span-2' : '' }}">
                                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $rubrik->color ?: '#1E3A8A' }}"></span>
                                    <span class="truncate text-slate-800 group-hover:text-blue-950">{{ $rubrik->name }}</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="pt-3 border-t border-slate-200/80 space-y-2 text-2xs text-slate-600">
                            <div class="flex items-center space-x-2 text-slate-700 font-medium">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                <span>Alur Redaksi Berlapis (Reporter &rarr; Editor &rarr; Kadiv)</span>
                            </div>
                            <div class="flex items-center space-x-2 text-slate-700 font-medium">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                                <span>Kerahasiaan & Perlindungan Identitas Narasumber Anak</span>
                            </div>
                            <div class="flex items-center space-x-2 text-slate-700 font-medium">
                                <i data-lucide="history" class="w-3.5 h-3.5 text-amber-600 shrink-0"></i>
                                <span>Arsip Digital Terbuka & Rekam Jejak Terverifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- 2. KABAR TERBARU & SIDEBAR TERPOPULER (8 COLS + 4 COLS) -->
    <section>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Main Content Feed (8 Cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Section Header -->
                <div class="flex items-center justify-between pb-3 border-b-2 border-slate-900">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-red-600 rounded-xs"></span>
                        <h2 class="font-black text-lg sm:text-xl uppercase tracking-tight text-slate-950">
                            Kabar Terkini SPELAND
                        </h2>
                    </div>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-blue-900 hover:text-red-600 transition flex items-center">
                        <span>Indeks Berita</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 ml-0.5"></i>
                    </a>
                </div>

                <!-- 2-Column Latest News Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($latestArticles as $article)
                        <x-article-card :article="$article" layout="standard" />
                    @empty
                        <div class="col-span-2 p-8 sm:p-12 text-center bg-slate-50/80 rounded-2xl border border-slate-200 space-y-3">
                            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-900 flex items-center justify-center mx-auto">
                                <i data-lucide="newspaper" class="w-6 h-6"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">Belum Ada Berita yang Diterbitkan</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto">
                                Tim redaksi dan reporter sekolah sedang melakukan liputan kegiatan di lapangan. Berita yang disetujui akan tayang di bagian ini.
                            </p>
                            @auth
                                <div class="pt-2">
                                    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-bold hover:bg-blue-900 transition shadow-xs">
                                        <i data-lucide="plus" class="w-3.5 h-3.5 mr-1"></i>
                                        Buat Naskah Berita
                                    </a>
                                </div>
                            @endauth
                        </div>
                    @endforelse
                </div>

                <!-- Category Showcase Strip: Pendidikan & Prestasi -->
                @if($pendidikanArticles->isNotEmpty())
                    <div class="pt-6 border-t border-slate-200">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 bg-blue-900 rounded-full"></span>
                                <h3 class="font-extrabold text-base uppercase tracking-tight text-slate-900">
                                    Pendidikan & Prestasi Sekolah
                                </h3>
                            </div>
                            <a href="{{ route('articles.category', 'pendidikan') }}" class="text-xs font-bold text-slate-600 hover:text-blue-950 transition">
                                Lihat Rubrik &rarr;
                            </a>
                        </div>

                        <div class="space-y-4">
                            @foreach($pendidikanArticles->take(3) as $pendidikan)
                                <x-article-card :article="$pendidikan" layout="horizontal" />
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Sticky Sidebar (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- 1. Berita Terpopuler Ranking -->
                <x-sidebar-popular :popularArticles="$popularArticles" />

                <!-- 2. Profil Sekolah Banner -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 shadow-2xs space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-950 text-white flex items-center justify-center font-bold text-sm">
                            9
                        </div>
                        <div>
                            <span class="font-extrabold text-xs text-slate-900 block leading-tight">SMP Negeri 9 Probolinggo</span>
                            <span class="text-2xs text-slate-500">Sekolah Adiwiyata & Literasi</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed font-sans">
                        Mewujudkan generasi pelajar yang beriman, berkarakter mulia, unggul dalam prestasi, dan berwawasan lingkungan hijau.
                    </p>
                    <div class="pt-2 border-t border-slate-200/80 flex items-center justify-between text-2xs font-bold">
                        <a href="{{ route('about') }}" class="text-blue-950 hover:underline">Profil Lengkap &rarr;</a>
                        <span class="text-slate-400">Kota Probolinggo</span>
                    </div>
                </div>

                <!-- 3. Arsip Cepat -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs space-y-3">
                    <h4 class="font-extrabold text-xs uppercase tracking-wider text-slate-900 flex items-center">
                        <i data-lucide="archive" class="w-4 h-4 mr-1.5 text-slate-600"></i>
                        Arsip Berita Bulanan
                    </h4>
                    <p class="text-2xs text-slate-500 leading-relaxed">
                        Telusuri seluruh dokumentasi berita sekolah berdasarkan edisi tahun dan bulan publikasi.
                    </p>
                    <a href="{{ route('articles.archive') }}" class="w-full inline-flex items-center justify-center py-2.5 bg-slate-100 hover:bg-blue-950 hover:text-white text-slate-800 text-xs font-bold rounded-xl transition shadow-2xs">
                        Buka Arsip Publikasi
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. OPINI & ESAI WARGA SEKOLAH -->
    <section class="bg-gradient-to-br from-amber-50/60 via-white to-slate-50 border border-amber-200/60 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-amber-200/80">
            <div>
                <span class="text-3xs uppercase tracking-widest font-black text-amber-800 block mb-1">GAGASAN & SUARA WARGA SEKOLAH</span>
                <h2 class="font-serif font-black text-xl sm:text-2xl text-slate-950 tracking-tight">
                    Opini, Esai, dan Karya Literasi
                </h2>
            </div>
            <a href="{{ route('articles.opinion') }}" class="text-xs font-bold text-amber-900 hover:text-amber-700 transition flex items-center shrink-0">
                <span>Lihat Semua Tulisan Opini</span>
                <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($opiniArticles as $opini)
                <article class="bg-white border border-amber-200/60 rounded-2xl p-5 shadow-2xs flex flex-col justify-between hover:shadow-md transition group">
                    <div class="space-y-3">
                        <span class="text-4xl font-serif text-amber-300 font-black leading-none block -mb-2">&ldquo;</span>
                        <h3 class="font-serif font-bold text-base text-slate-900 group-hover:text-blue-950 transition leading-snug">
                            <a href="{{ route('articles.show', $opini->slug) }}">
                                {{ $opini->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed font-sans">
                            {{ $opini->excerpt }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-2xs text-slate-500">
                        <div class="flex items-center space-x-2">
                            <img src="{{ $opini->author->avatar_url }}" alt="" class="w-6 h-6 rounded-full object-cover border border-slate-200">
                            <div>
                                <span class="font-bold text-slate-900 block leading-tight">{{ $opini->author->name }}</span>
                                <span class="text-3xs text-slate-400 block">{{ $opini->author->title ?: 'Kontributor Opini' }}</span>
                            </div>
                        </div>
                        <span class="text-slate-400">{{ $opini->published_at ? $opini->published_at->locale('id')->isoFormat('D MMM Y') : '' }}</span>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-8 bg-white/70 rounded-2xl border border-amber-200/50 p-6 space-y-2">
                    <p class="text-xs text-slate-600 font-semibold">
                        Ruang Opini Terbuka untuk Seluruh Warga SMP Negeri 9 Probolinggo
                    </p>
                    <p class="text-2xs text-slate-500 max-w-lg mx-auto">
                        Murid dan dewan guru dapat mengirimkan karya tulis opini, catatan refleksi, esai budaya, atau resensi buku untuk diterbitkan di rubrik ini.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 bg-amber-800 hover:bg-amber-700 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                            <i data-lucide="send" class="w-3.5 h-3.5 mr-1.5"></i>
                            Kirim Naskah Opini Anda
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. STUDIO MULTIMEDIA (DARK LUXURY THEATER) -->
    <section class="bg-slate-950 text-white rounded-3xl p-6 sm:p-9 shadow-xl space-y-7 border border-slate-800">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-800">
            <div>
                <span class="text-3xs uppercase tracking-widest font-black text-red-400 flex items-center mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2 animate-ping"></span>
                    STUDIO KONTEN DIGITAL
                </span>
                <h2 class="font-sans font-black text-xl sm:text-2xl text-white tracking-tight">
                    Multimedia Jurnalistik SPELAND
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Liputan video kegiatan, galeri lensa sekolah, dan rekaman siniar edukasi.</p>
            </div>
            <div class="flex items-center space-x-2 text-xs font-bold">
                <a href="{{ route('multimedia.videos') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">Video</a>
                <a href="{{ route('multimedia.podcasts') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">Podcast</a>
                <a href="{{ route('multimedia.galleries') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">Galeri Foto</a>
            </div>
        </div>

        @if($videos->isNotEmpty() || $podcasts->isNotEmpty() || $galleries->isNotEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-7">
                <!-- Left: Featured Video (7 Cols) -->
                @php $featuredVideo = $videos->first(); @endphp
                <div class="lg:col-span-7 space-y-4">
                    @if($featuredVideo)
                        <div class="relative aspect-video w-full rounded-2xl overflow-hidden bg-slate-900 border border-slate-800 shadow-lg group">
                            @if($featuredVideo->youtube_id)
                                <iframe class="w-full h-full" 
                                        src="https://www.youtube.com/embed/{{ $featuredVideo->youtube_id }}" 
                                        title="{{ $featuredVideo->title }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            @else
                                <img src="{{ $featuredVideo->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-slate-950/40 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-2xl">
                                        <i data-lucide="play" class="w-7 h-7 ml-1 fill-white"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <span class="text-3xs uppercase font-extrabold tracking-wider text-red-400 block mb-1">VIDEO PILIHAN</span>
                            <h3 class="font-bold text-base sm:text-lg text-white leading-snug">
                                {{ $featuredVideo->title }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                {{ $featuredVideo->description }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Right: Podcast & Photo Album (5 Cols) -->
                <div class="lg:col-span-5 space-y-5">
                    @php $featuredPodcast = $podcasts->first(); @endphp
                    @if($featuredPodcast)
                        <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center justify-between text-2xs">
                                <span class="font-extrabold text-purple-400 uppercase tracking-wider flex items-center">
                                    <i data-lucide="mic" class="w-3.5 h-3.5 mr-1"></i>
                                    Episode #{{ $featuredPodcast->episode_number }}
                                </span>
                                <span class="text-slate-400 font-mono">{{ $featuredPodcast->duration ?: 'Audio' }}</span>
                            </div>
                            <h4 class="font-bold text-sm text-white leading-snug">
                                {{ $featuredPodcast->title }}
                            </h4>
                            <div class="flex items-center space-x-2 text-2xs text-slate-400">
                                <span>Host: {{ $featuredPodcast->host }}</span>
                                @if($featuredPodcast->guest)
                                    <span>&bull;</span>
                                    <span>Tamu: {{ $featuredPodcast->guest }}</span>
                                @endif
                            </div>
                            <a href="{{ route('multimedia.podcasts') }}" class="w-full inline-flex items-center justify-center py-2 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition shadow-sm space-x-1.5">
                                <i data-lucide="headphones" class="w-4 h-4 mr-1"></i>
                                <span>Dengarkan Podcast SPELAND</span>
                            </a>
                        </div>
                    @endif

                    @php $featuredGallery = $galleries->first(); @endphp
                    @if($featuredGallery)
                        <div class="bg-slate-900/90 border border-slate-800 rounded-2xl overflow-hidden group">
                            <a href="{{ route('multimedia.gallery.show', $featuredGallery->slug) }}" class="block relative aspect-[16/9] overflow-hidden">
                                <img src="{{ $featuredGallery->cover_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                                <span class="absolute bottom-3 left-3 bg-slate-950/80 backdrop-blur-xs text-white text-3xs font-bold px-2 py-1 rounded-md flex items-center">
                                    <i data-lucide="camera" class="w-3 h-3 mr-1 text-blue-400"></i>
                                    {{ $featuredGallery->photos_count }} Dokumentasi Foto
                                </span>
                            </a>
                            <div class="p-4">
                                <h4 class="font-bold text-xs text-white group-hover:text-blue-400 transition leading-snug">
                                    <a href="{{ route('multimedia.gallery.show', $featuredGallery->slug) }}">
                                        {{ $featuredGallery->title }}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Multimedia Studio Standby State -->
            <div class="text-center py-10 space-y-4 max-w-xl mx-auto">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 border border-slate-800 text-blue-400 flex items-center justify-center mx-auto shadow-inner">
                    <i data-lucide="clapperboard" class="w-7 h-7"></i>
                </div>
                <h3 class="font-bold text-base text-white">Studio Konten Digital Sedang Mempersiapkan Liputan</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Kanal video liputan, episode siniar podcast murid, dan album foto resolusi tinggi akan dipublikasikan secara berkala oleh tim divisi multimedia.
                </p>
                <div class="pt-2 flex justify-center space-x-3">
                    <a href="{{ route('editorial.structure') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-semibold transition">
                        Lihat Divisi Multimedia
                    </a>
                </div>
            </div>
        @endif
    </section>

</div>
@endsection
