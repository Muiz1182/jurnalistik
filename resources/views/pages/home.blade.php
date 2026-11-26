@extends('layouts.app')

@section('title', 'JURNALISTIK SPELAND | Portal Berita Digital Resmi SMP Negeri 9 Probolinggo')
@section('meta_description', 'Portal berita dan publikasi jurnalistik resmi SMP Negeri 9 Probolinggo. Mengabarkan fakta kegiatan, prestasi, adiwiyata, dan karya literasi murid dengan standar pers terpercaya.')

@section('content')
<div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-10 sm:space-y-14">

    <!-- 1. HERO FRONT-PAGE SHOWCASE (JAWA POS ASYMMETRIC HEADLINE + TERPOPULER) -->
    <section class="border-b border-slate-200/90 pb-8 sm:pb-10">
        @if($heroHeadline)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Main Lead Headline & Sub-Headlines (8 Columns) -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Lead Headline Article -->
                    <article class="group">
                        <!-- Dominant Media Container (Calibrated height so headline title is visible above the fold) -->
                        <div class="relative w-full aspect-[16/10] sm:aspect-[16/9] max-h-[360px] sm:max-h-[390px] overflow-hidden rounded-2xl bg-slate-900 shadow-sm mb-4">
                            <a href="{{ route('articles.show', $heroHeadline->slug) }}" class="block w-full h-full">
                                <img src="{{ $heroHeadline->featured_image_url }}" 
                                     alt="{{ $heroHeadline->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-102 transition duration-500 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                            </a>
                            
                            <!-- Category Badge & Breaking Pulse -->
                            <div class="absolute top-4 left-4 flex flex-wrap items-center gap-2 z-10">
                                <a href="{{ route('articles.category', $heroHeadline->category->slug) }}" 
                                   class="bg-[#0B2545]/95 hover:bg-red-600 text-white text-xs font-black uppercase px-3 py-1.5 rounded-lg tracking-wider shadow-sm transition border border-white/10">
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
                                    <p class="text-3xs text-slate-300 line-clamp-1 italic font-sans bg-slate-950/70 backdrop-blur-xs px-2.5 py-1 rounded inline-block">
                                        Foto: {{ $heroHeadline->image_caption }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Headline Typography & Details -->
                        <div class="space-y-2.5">
                            <div class="flex flex-wrap items-center text-xs text-slate-500 gap-x-3 gap-y-1 font-medium">
                                <span class="inline-flex items-center text-slate-900 font-bold">
                                    <i data-lucide="pen-tool" class="w-3.5 h-3.5 mr-1 text-red-600"></i>
                                    {{ $heroHeadline->author->name }}
                                </span>
                                <span>&bull;</span>
                                <span class="text-slate-600">{{ $heroHeadline->published_at ? $heroHeadline->published_at->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : 'Baru' }}</span>
                                <span>&bull;</span>
                                <span class="inline-flex items-center text-slate-500 font-semibold">
                                    <i data-lucide="eye" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                                    {{ number_format($heroHeadline->views_count) }} dibaca
                                </span>
                            </div>

                            <h1 class="font-serif font-black text-2xl sm:text-3xl lg:text-4xl text-slate-950 group-hover:text-red-600 transition leading-tight tracking-tight">
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

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('articles.show', $heroHeadline->slug) }}" 
                                   class="inline-flex items-center text-xs sm:text-sm font-bold text-red-600 hover:text-red-700 transition group/link">
                                    <span>Baca Berita Selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5 group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                                <span class="text-3xs text-slate-500 font-bold bg-slate-100 px-2.5 py-1 rounded-md">
                                    ~{{ $heroHeadline->reading_time }} menit baca
                                </span>
                            </div>
                        </div>
                    </article>

                    <!-- Sub-Headlines Grid (Jawa Pos Supporting Top Stories) -->
                    @if($secondaryHeadlines->isNotEmpty())
                        <div class="pt-6 border-t border-slate-200">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
                                <h2 class="font-black text-xs uppercase tracking-wider text-slate-900 flex items-center border-l-3 border-red-600 pl-2">
                                    Sorotan Utama Hari Ini
                                </h2>
                                <span class="text-3xs uppercase tracking-widest font-bold text-slate-400">PILIHAN REDAKSI</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                @foreach($secondaryHeadlines as $secondary)
                                    <article class="group bg-white border border-slate-200/80 rounded-xl overflow-hidden hover:shadow-sm transition duration-300 flex flex-col justify-between p-3">
                                        <div>
                                            <a href="{{ route('articles.show', $secondary->slug) }}" class="aspect-[16/10] overflow-hidden rounded-lg bg-slate-100 block mb-2.5">
                                                <img src="{{ $secondary->featured_image_url }}" 
                                                     alt="{{ $secondary->title }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                            </a>
                                            <a href="{{ route('articles.category', $secondary->category->slug) }}" 
                                               class="text-3xs font-black uppercase text-red-600 hover:text-[#0B2545] tracking-wider block mb-1">
                                                {{ $secondary->category->name }}
                                            </a>
                                            <h3 class="font-serif font-bold text-xs sm:text-sm text-slate-900 group-hover:text-red-600 transition leading-snug line-clamp-2">
                                                <a href="{{ route('articles.show', $secondary->slug) }}">
                                                    {{ $secondary->title }}
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="flex items-center text-3xs text-slate-400 mt-2.5 pt-2 border-t border-slate-100">
                                            <span class="truncate">{{ $secondary->author->name }}</span>
                                            <span class="mx-1">&bull;</span>
                                            <span>{{ $secondary->published_at ? $secondary->published_at->locale('id')->diffForHumans() : '' }}</span>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column (Jawa Pos Terpopuler & Hotline) (4 Columns) -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- 1. Signature Numbered Terpopuler Rankings -->
                    <x-sidebar-popular :popularArticles="$popularArticles" />

                    <!-- 2. Meja Liputan & Whistleblower Box -->
                    <div class="bg-gradient-to-br from-[#0B2545] to-[#07192F] text-white p-5 rounded-2xl shadow-sm space-y-2.5 border border-slate-800">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="radio" class="w-4 h-4 text-red-400 animate-pulse"></i>
                            <span class="text-3xs font-black uppercase tracking-wider text-slate-300">KANAL LIPUTAN MURID</span>
                        </div>
                        <h4 class="font-serif font-bold text-sm sm:text-base text-white leading-snug">
                            Punya Info Kegiatan atau Prestasi Sekolah?
                        </h4>
                        <p class="text-xs text-slate-300 leading-relaxed font-sans">
                            Kirimkan naskah rilis kelas, liputan ekstrakurikuler, atau karya opini Anda langsung kepada dewan redaksi.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center text-xs font-bold text-red-400 hover:text-white transition pt-1">
                            <span>Hubungi Meja Redaksi</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    @endif

    <!-- 2. SPECIAL COVERAGE / LIPUTAN KHUSUS DOSSIER (IF ACTIVE) -->
    @if($specialCoverage && $specialCoverage->articles->isNotEmpty())
        <section class="bg-gradient-to-r from-[#0B2545] via-[#07192F] to-slate-950 text-white rounded-2xl p-5 sm:p-7 shadow-md border border-slate-800">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-800 mb-5">
                <div class="flex items-center space-x-3">
                    <span class="bg-red-600 text-white text-3xs font-black uppercase px-2.5 py-1 rounded tracking-wider shadow-xs">
                        LIPUTAN KHUSUS
                    </span>
                    <h2 class="font-serif font-black text-lg sm:text-xl text-white tracking-tight">
                        {{ $specialCoverage->title }}
                    </h2>
                </div>
                <a href="{{ route('multimedia.special-coverages') }}" class="text-xs font-bold text-red-400 hover:text-white transition flex items-center">
                    <span>Lihat Liputan Khusus Lainnya</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($specialCoverage->articles->take(3) as $specArticle)
                    <article class="group bg-slate-900/80 border border-slate-800 rounded-xl overflow-hidden p-3.5 flex flex-col justify-between hover:border-slate-700 transition">
                        <div>
                            <a href="{{ route('articles.show', $specArticle->slug) }}" class="aspect-[16/10] overflow-hidden rounded-lg bg-slate-800 block mb-3">
                                <img src="{{ $specArticle->featured_image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </a>
                            <span class="text-3xs font-black text-red-400 uppercase tracking-wider block mb-1">
                                {{ $specArticle->category->name }}
                            </span>
                            <h3 class="font-serif font-bold text-sm text-white group-hover:text-red-400 transition leading-snug line-clamp-2">
                                <a href="{{ route('articles.show', $specArticle->slug) }}">
                                    {{ $specArticle->title }}
                                </a>
                            </h3>
                        </div>
                        <div class="flex items-center text-3xs text-slate-400 mt-3 pt-2 border-t border-slate-800">
                            <span>{{ $specArticle->published_at ? $specArticle->published_at->locale('id')->diffForHumans() : '' }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 3. RUBRIKASI SIGNATURE JAWA POS (1 LEAD BESAR + 3 KARTU HORIZONTAL) -->
    @php
        $rubrikLead = null;
        $rubrikList = collect();
        $rubrikTitle = 'Pendidikan & Prestasi Sekolah';
        $rubrikSlug = 'pendidikan';

        if (isset($pendidikanArticles) && $pendidikanArticles->isNotEmpty()) {
            $rubrikLead = $pendidikanArticles->first();
            $rubrikList = $pendidikanArticles->slice(1)
                ->concat($prestasiArticles ?? collect())
                ->concat($kegiatanArticles ?? collect())
                ->take(3);
            $rubrikTitle = 'Pendidikan & Prestasi Sekolah';
            $rubrikSlug = 'pendidikan';
        } elseif (isset($prestasiArticles) && $prestasiArticles->isNotEmpty()) {
            $rubrikLead = $prestasiArticles->first();
            $rubrikList = $prestasiArticles->slice(1)
                ->concat($kegiatanArticles ?? collect())
                ->take(3);
            $rubrikTitle = 'Prestasi & Kejuaraan Sekolah';
            $rubrikSlug = 'prestasi';
        } elseif (isset($kegiatanArticles) && $kegiatanArticles->isNotEmpty()) {
            $rubrikLead = $kegiatanArticles->first();
            $rubrikList = $kegiatanArticles->slice(1)->take(3);
            $rubrikTitle = 'Kegiatan & Dinamika Sekolah';
            $rubrikSlug = 'kegiatan';
        }
    @endphp

    @if($rubrikLead)
        <section class="border-b border-slate-200/90 pb-10">
            <!-- Jawa Pos Rubric Header -->
            <div class="flex items-center justify-between pb-3 border-b-2 border-slate-900 mb-6">
                <div class="flex items-center space-x-2">
                    <h2 class="font-black text-lg sm:text-xl uppercase tracking-tight text-slate-950 border-l-4 border-red-600 pl-3">
                        {{ $rubrikTitle }}
                    </h2>
                </div>
                <div class="flex items-center space-x-3 text-xs font-bold">
                    <a href="{{ route('articles.category', $rubrikSlug) }}" class="text-red-600 hover:text-red-700 transition flex items-center group">
                        <span>Lihat Semua</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 ml-0.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <!-- 1 Lead Besar (5 Columns) -->
                <div class="lg:col-span-5">
                    <article class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-2xs hover:shadow-md transition duration-300 group flex flex-col h-full">
                        <a href="{{ route('articles.show', $rubrikLead->slug) }}" class="aspect-[16/10] overflow-hidden bg-slate-900 block relative">
                            <img src="{{ $rubrikLead->featured_image_url }}" alt="{{ $rubrikLead->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-3 left-3 bg-red-600 text-white text-3xs font-black uppercase tracking-wider px-2.5 py-1 rounded shadow-xs">
                                {{ $rubrikLead->category->name }}
                            </span>
                        </a>
                        <div class="p-5 flex flex-col justify-between flex-grow space-y-3">
                            <div>
                                <div class="flex items-center text-3xs text-slate-400 mb-2 space-x-2 font-medium">
                                    <span>{{ $rubrikLead->published_at ? $rubrikLead->published_at->locale('id')->isoFormat('D MMMM Y') : 'Baru' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $rubrikLead->author->name }}</span>
                                </div>
                                <h3 class="font-serif font-black text-base sm:text-lg text-slate-900 group-hover:text-red-600 transition leading-snug">
                                    <a href="{{ route('articles.show', $rubrikLead->slug) }}">
                                        {{ $rubrikLead->title }}
                                    </a>
                                </h3>
                                @if($rubrikLead->excerpt)
                                    <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed font-sans">
                                        {{ $rubrikLead->excerpt }}
                                    </p>
                                @endif
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-2xs text-slate-500">
                                <span class="font-bold text-red-600 group-hover:underline flex items-center">
                                    Baca Ulasan &rarr;
                                </span>
                                <span class="flex items-center text-slate-400 font-medium">
                                    <i data-lucide="eye" class="w-3 h-3 mr-1 text-slate-400"></i>
                                    {{ number_format($rubrikLead->views_count) }} dibaca
                                </span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- 3 Stacked Horizontal Cards (7 Columns) -->
                <div class="lg:col-span-7 space-y-4">
                    @foreach($rubrikList as $item)
                        <x-article-card :article="$item" layout="horizontal" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 4. KABAR TERBARU & SIDEBAR INFORMASI (8 COLS + 4 COLS) -->
    <section>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Main Content Feed (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Section Header -->
                <div class="flex items-center justify-between pb-3 border-b-2 border-slate-900">
                    <div class="flex items-center space-x-2">
                        <h2 class="font-black text-lg sm:text-xl uppercase tracking-tight text-slate-950 border-l-4 border-red-600 pl-3">
                            Kabar Terkini SPELAND
                        </h2>
                    </div>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 transition flex items-center group">
                        <span>Indeks Berita</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 ml-0.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>

                <!-- 2-Column Latest News Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @forelse($latestArticles as $article)
                        <x-article-card :article="$article" layout="standard" />
                    @empty
                        <div class="col-span-2 p-8 sm:p-12 text-center bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto">
                                <i data-lucide="newspaper" class="w-6 h-6"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">Belum Ada Berita yang Diterbitkan</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto">
                                Tim redaksi dan jurnalis pelajar sedang melakukan peliputan kegiatan di lingkungan sekolah.
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Category Showcase Strip: Adiwiyata & Lingkungan -->
                @if($lingkunganArticles->isNotEmpty())
                    <div class="pt-8 border-t border-slate-200">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-5">
                            <h3 class="font-black text-base uppercase tracking-tight text-slate-900 border-l-3 border-emerald-600 pl-2.5">
                                Adiwiyata & Lingkungan Hidup
                            </h3>
                            <a href="{{ route('articles.category', 'lingkungan') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                                Lihat Rubrik &rarr;
                            </a>
                        </div>

                        <div class="space-y-3.5">
                            @foreach($lingkunganArticles->take(3) as $lingkungan)
                                <x-article-card :article="$lingkungan" layout="horizontal" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Sticky Sidebar (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                @if(!$heroHeadline)
                    <!-- Berita Terpopuler Ranking -->
                    <x-sidebar-popular :popularArticles="$popularArticles" />
                @endif

                <!-- 1. Profil Sekolah Broadside Widget -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs space-y-3">
                    <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-[#0B2545] text-white flex items-center justify-center font-serif font-black text-base shadow-xs shrink-0">
                            9
                        </div>
                        <div>
                            <span class="font-black text-xs text-slate-900 block leading-tight">SMP NEGERI 9 PROBOLINGGO</span>
                            <span class="text-3xs text-red-600 font-extrabold uppercase tracking-wider">Sekolah Adiwiyata Mandiri</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed font-sans">
                        Mendidik tunas bangsa berintegritas tinggi, berwawasan lingkungan hijau, serta unggul dalam literasi dan inovasi digital.
                    </p>
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-2xs font-bold">
                        <a href="{{ route('about') }}" class="text-[#0B2545] hover:text-red-600 transition">Profil Sekolah &rarr;</a>
                        <span class="text-slate-400 font-normal">Kota Probolinggo</span>
                    </div>
                </div>

                <!-- 2. Arsip Berita Bulanan -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 shadow-2xs space-y-3">
                    <h4 class="font-black text-xs uppercase tracking-wider text-slate-900 flex items-center border-l-3 border-[#0B2545] pl-2">
                        Arsip Dokumentasi Berita
                    </h4>
                    <p class="text-2xs text-slate-500 leading-relaxed">
                        Telusuri seluruh edisi berita sekolah yang telah terbit berdasarkan filter tahun dan bulan publikasi.
                    </p>
                    <a href="{{ route('articles.archive') }}" class="w-full inline-flex items-center justify-center py-2.5 bg-white hover:bg-[#0B2545] hover:text-white text-slate-800 text-xs font-bold rounded-xl transition border border-slate-200 shadow-2xs">
                        <i data-lucide="archive" class="w-3.5 h-3.5 mr-1.5 text-slate-400"></i>
                        <span>Buka Arsip Publikasi</span>
                    </a>
                </div>

                <!-- 3. Saluran Redaksi & Hak Jawab -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs space-y-2.5 text-2xs text-slate-600">
                    <span class="text-3xs uppercase tracking-wider text-slate-400 font-black block">KODE ETIK & TRANSPARANSI</span>
                    <p class="leading-relaxed">
                        Redaksi Jurnalistik SPELAND mematuhi kode etik jurnalistik pelajar dan pedoman pemberitaan ramah anak.
                    </p>
                    <div class="pt-1 flex flex-col space-y-1 font-bold text-slate-800">
                        <a href="{{ route('journalistic.guidelines') }}" class="hover:text-red-600 transition flex items-center">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 mr-1.5 text-emerald-600"></i>
                            Pedoman Ramah Anak &rarr;
                        </a>
                        <a href="{{ route('contact') }}" class="hover:text-red-600 transition flex items-center">
                            <i data-lucide="mail" class="w-3.5 h-3.5 mr-1.5 text-red-600"></i>
                            Permohonan Hak Jawab &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 5. OPINI & ESAI (JAWA POS BROADISDE EDITORIAL OPINION) -->
    <section class="bg-gradient-to-br from-amber-50/50 via-white to-slate-50 border border-amber-200/60 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-amber-200/70">
            <div>
                <span class="text-3xs uppercase tracking-widest font-black text-amber-800 block mb-1">GAGASAN & SUARA WARGA SEKOLAH</span>
                <h2 class="font-serif font-black text-xl sm:text-2xl text-slate-950 tracking-tight border-l-4 border-amber-600 pl-3">
                    Kolom Opini, Esai, & Literasi
                </h2>
            </div>
            <a href="{{ route('articles.opinion') }}" class="text-xs font-bold text-amber-900 hover:text-red-600 transition flex items-center shrink-0 group">
                <span>Lihat Semua Kolom Opini</span>
                <i data-lucide="arrow-right" class="w-4 h-4 ml-1 group-hover:translate-x-0.5 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($opiniArticles as $opini)
                <article class="bg-white border border-amber-200/70 rounded-2xl p-5 shadow-2xs flex flex-col justify-between hover:shadow-md transition group">
                    <div class="space-y-3">
                        <span class="text-4xl font-serif text-amber-400 font-black leading-none block -mb-2">&ldquo;</span>
                        <h3 class="font-serif font-bold text-base text-slate-900 group-hover:text-red-600 transition leading-snug">
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
                    <p class="text-xs text-slate-700 font-bold">
                        Ruang Opini Terbuka untuk Seluruh Warga SMP Negeri 9 Probolinggo
                    </p>
                    <p class="text-2xs text-slate-500 max-w-lg mx-auto">
                        Murid dan dewan guru dapat mengirimkan karya tulis opini, catatan refleksi, esai budaya, atau resensi buku untuk diterbitkan di rubrik ini.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 bg-amber-800 hover:bg-amber-700 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                            <i data-lucide="send" class="w-3.5 h-3.5 mr-1.5"></i>
                            Kirim Naskah Opini
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. STUDIO MULTIMEDIA (DARK LUXURY BROADCAST THEATER) -->
    <section class="bg-[#0B2545] text-white rounded-3xl p-6 sm:p-9 shadow-xl space-y-7 border border-[#07192F]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-700/80">
            <div>
                <span class="text-3xs uppercase tracking-widest font-black text-red-400 flex items-center mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2 animate-ping"></span>
                    LENSA & MULTIMEDIA
                </span>
                <h2 class="font-sans font-black text-xl sm:text-2xl text-white tracking-tight">
                    Studio Multimedia Jurnalistik SPELAND
                </h2>
                <p class="text-xs text-slate-300 mt-0.5">Liputan video kegiatan, galeri lensa sekolah, dan rekaman siniar podcast.</p>
            </div>
            <div class="flex items-center space-x-2 text-xs font-bold">
                <a href="{{ route('multimedia.videos') }}" class="px-3 py-1.5 rounded-lg bg-[#07192F] hover:bg-red-600 text-slate-200 hover:text-white transition">Video</a>
                <a href="{{ route('multimedia.podcasts') }}" class="px-3 py-1.5 rounded-lg bg-[#07192F] hover:bg-red-600 text-slate-200 hover:text-white transition">Podcast</a>
                <a href="{{ route('multimedia.galleries') }}" class="px-3 py-1.5 rounded-lg bg-[#07192F] hover:bg-red-600 text-slate-200 hover:text-white transition">Galeri Foto</a>
            </div>
        </div>

        @if($videos->isNotEmpty() || $podcasts->isNotEmpty() || $galleries->isNotEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-7">
                <!-- Left: Featured Video (7 Cols) -->
                @php $featuredVideo = $videos->first(); @endphp
                <div class="lg:col-span-7 space-y-4">
                    @if($featuredVideo)
                        <div class="relative aspect-video w-full rounded-2xl overflow-hidden bg-slate-950 border border-slate-700 shadow-lg group">
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
                                    <div class="w-16 h-16 rounded-full bg-red-600 text-white flex items-center justify-center shadow-2xl">
                                        <i data-lucide="play" class="w-7 h-7 ml-1 fill-white"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <span class="text-3xs uppercase font-black tracking-wider text-red-400 block mb-1">VIDEO LIPUTAN PILIHAN</span>
                            <h3 class="font-bold text-base sm:text-lg text-white leading-snug">
                                {{ $featuredVideo->title }}
                            </h3>
                            <p class="text-xs text-slate-300 mt-1 line-clamp-2 leading-relaxed">
                                {{ $featuredVideo->description }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Right: Podcast & Photo Album (5 Cols) -->
                <div class="lg:col-span-5 space-y-5">
                    @php $featuredPodcast = $podcasts->first(); @endphp
                    @if($featuredPodcast)
                        <div class="bg-[#07192F] border border-slate-700 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center justify-between text-2xs">
                                <span class="font-black text-red-400 uppercase tracking-wider flex items-center">
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
                            <a href="{{ route('multimedia.podcasts') }}" class="w-full inline-flex items-center justify-center py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow-sm space-x-1.5">
                                <i data-lucide="headphones" class="w-4 h-4 mr-1"></i>
                                <span>Dengarkan Podcast SPELAND</span>
                            </a>
                        </div>
                    @endif

                    @php $featuredGallery = $galleries->first(); @endphp
                    @if($featuredGallery)
                        <div class="bg-[#07192F] border border-slate-700 rounded-2xl overflow-hidden group">
                            <a href="{{ route('multimedia.gallery.show', $featuredGallery->slug) }}" class="block relative aspect-[16/9] overflow-hidden">
                                <img src="{{ $featuredGallery->cover_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                                <span class="absolute bottom-3 left-3 bg-slate-950/80 backdrop-blur-xs text-white text-3xs font-bold px-2 py-1 rounded-md flex items-center">
                                    <i data-lucide="camera" class="w-3 h-3 mr-1 text-red-400"></i>
                                    {{ $featuredGallery->photos_count }} Dokumentasi Foto
                                </span>
                            </a>
                            <div class="p-4">
                                <h4 class="font-bold text-xs text-white group-hover:text-red-400 transition leading-snug">
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
                <div class="w-14 h-14 rounded-2xl bg-[#07192F] border border-slate-700 text-red-400 flex items-center justify-center mx-auto shadow-inner">
                    <i data-lucide="clapperboard" class="w-7 h-7"></i>
                </div>
                <h3 class="font-bold text-base text-white">Studio Konten Digital Sedang Mempersiapkan Liputan</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Kanal video liputan, episode podcast murid, dan dokumentasi foto resolusi tinggi akan dipublikasikan oleh tim divisi multimedia.
                </p>
                <div class="pt-2 flex justify-center space-x-3">
                    <a href="{{ route('editorial.structure') }}" class="px-4 py-2 bg-[#07192F] hover:bg-slate-800 text-white rounded-lg text-xs font-semibold transition border border-slate-700">
                        Lihat Divisi Multimedia
                    </a>
                </div>
            </div>
        @endif
    </section>

</div>
@endsection
