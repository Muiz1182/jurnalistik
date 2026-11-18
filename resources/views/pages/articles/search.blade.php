@extends('layouts.app')

@section('title', 'Pencarian: ' . ($q ?: 'Berita') . ' - JURNALISTIK SPELAND')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Search Form Bar -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-6 mb-8 shadow-xs">
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-4 flex items-center">
            <i data-lucide="search" class="w-6 h-6 mr-2 text-blue-900"></i>
            Pencarian Berita & Arsip
        </h1>

        <form action="{{ route('articles.search') }}" method="GET" class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" 
                           name="q" 
                           value="{{ $q }}" 
                           placeholder="Masukkan kata kunci pencarian..." 
                           class="w-full bg-white border border-slate-300 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                </div>

                <select name="kategori" class="bg-white border border-slate-300 rounded-lg px-3 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900 sm:w-48">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="urutan" class="bg-white border border-slate-300 rounded-lg px-3 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900 sm:w-40">
                    <option value="relevansi" {{ request('urutan') === 'relevansi' ? 'selected' : '' }}>Relevansi</option>
                    <option value="terbaru" {{ request('urutan') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terpopuler" {{ request('urutan') === 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                </select>

                <button type="submit" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs px-6 py-2.5 rounded-lg transition shadow-sm shrink-0">
                    Cari Sekarang
                </button>
            </div>
        </form>

        @if(!empty($q))
            <div class="mt-4 pt-4 border-t border-slate-200 text-xs text-slate-600 flex items-center justify-between">
                <span>Ditemukan <strong>{{ $articles->total() }}</strong> hasil untuk kata kunci: <strong class="text-blue-950">&ldquo;{{ $q }}&rdquo;</strong></span>
                <span class="text-slate-400">Hasil Pencarian Terindeks</span>
            </div>
        @endif
    </div>

    <!-- Results Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-8 space-y-4">
            @forelse($articles as $article)
                <x-article-card :article="$article" layout="horizontal" />
            @empty
                <div class="py-12 text-center bg-white rounded-xl border border-dashed border-slate-200 p-8">
                    <i data-lucide="search-x" class="w-12 h-12 text-slate-400 mx-auto mb-3"></i>
                    <h3 class="text-base font-bold text-slate-800">Tidak ada berita yang cocok</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Coba gunakan kata kunci yang lebih umum atau periksa ejaan kata yang Anda masukkan.
                    </p>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>

        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>

    </div>

</div>
@endsection
