@extends('layouts.app')

@section('title', 'Semua Berita & Publikasi - JURNALISTIK SPELAND')
@section('meta_description', 'Indeks seluruh liputan berita, artikel, dan dokumentasi resmi SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <!-- Header Section -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Semua Berita</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-1 border-t border-slate-100">
            <div>
                <span class="text-3xs uppercase tracking-widest font-black text-red-600 font-mono block mb-1">ARSIP PERS SEKOLAH</span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                    Semua Berita & Publikasi
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                    Kumpulan liputan fakta, artikel, kegiatan, dan pengumuman resmi SMP Negeri 9 Probolinggo.
                </p>
            </div>

            <!-- Filter bar -->
            <form method="GET" action="{{ route('articles.index') }}" class="flex flex-wrap items-center gap-2">
                <select name="kategori" onchange="this.form.submit()" class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    <option value="">Semua Rubrik</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('kategori') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="urutan" onchange="this.form.submit()" class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    <option value="terbaru" {{ request('urutan') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="populer" {{ request('urutan') === 'populer' ? 'selected' : '' }}>Terpopuler</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Layout Grid with Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Articles Grid (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <div class="col-span-2 bg-white border border-slate-200/90 rounded-2xl p-8 sm:p-12 text-center shadow-2xs space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-900 flex items-center justify-center mx-auto shadow-2xs">
                            <i data-lucide="newspaper" class="w-7 h-7"></i>
                        </div>
                        <div class="max-w-md mx-auto space-y-1.5">
                            <h2 class="text-base sm:text-lg font-serif font-bold text-slate-900">Belum Ada Naskah Berita Diterbitkan</h2>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                                Tim redaksi dan reporter sedang mempersiapkan artikel liputan terkini. Naskah yang disetujui akan tayang di bagian ini.
                            </p>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition border border-slate-200">
                                <i data-lucide="home" class="w-3.5 h-3.5 mr-1.5"></i>
                                <span>Kembali ke Beranda</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="pt-4">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>

    </div>

</div>
@endsection
