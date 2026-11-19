@extends('layouts.app')

@section('title', 'Pencarian: ' . ($q ?: 'Berita') . ' - JURNALISTIK SPELAND')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <!-- Search Form Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Pencarian</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-blue-900 font-mono block mb-1">MESIN PENCARI PORTAL</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight mb-4">
                Pencarian Berita & Arsip
            </h1>

            <form action="{{ route('articles.search') }}" method="GET" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <input type="text" 
                               name="q" 
                               value="{{ $q }}" 
                               placeholder="Masukkan kata kunci topik, nama jurnalis, atau agenda sekolah..." 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                    </div>

                    <select name="kategori" class="bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900 sm:w-48">
                        <option value="">Semua Rubrik</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="urutan" class="bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900 sm:w-40">
                        <option value="relevansi" {{ request('urutan') === 'relevansi' ? 'selected' : '' }}>Relevansi</option>
                        <option value="terbaru" {{ request('urutan') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terpopuler" {{ request('urutan') === 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                    </select>

                    <button type="submit" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition shadow-xs shrink-0 flex items-center justify-center">
                        <i data-lucide="search" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </form>

            @if(!empty($q))
                <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-600 flex items-center justify-between">
                    <span>Ditemukan <strong>{{ $articles->total() }}</strong> hasil untuk kata kunci: <strong class="text-blue-950">&ldquo;{{ $q }}&rdquo;</strong></span>
                    <span class="text-slate-400 font-mono text-3xs">Pencarian Terindeks</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Results Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-8 space-y-4">
            @forelse($articles as $article)
                <x-article-card :article="$article" layout="horizontal" />
            @empty
                <div class="bg-white border border-slate-200/90 rounded-2xl p-8 sm:p-12 text-center shadow-2xs space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto shadow-2xs">
                        <i data-lucide="search-x" class="w-7 h-7"></i>
                    </div>
                    <div class="max-w-md mx-auto space-y-1.5">
                        <h2 class="text-base sm:text-lg font-serif font-bold text-slate-900">
                            Tidak Ada Naskah yang Cocok
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-sans">
                            Tidak ditemukan berita dengan kata kunci yang Anda masukkan. Coba gunakan istilah lain atau jelajahi rubrikasi berita.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('articles.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition">
                            <i data-lucide="layers" class="w-3.5 h-3.5 mr-1.5"></i>
                            <span>Lihat Semua Berita</span>
                        </a>
                    </div>
                </div>
            @endforelse

            @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>

    </div>

</div>
@endsection
