@extends('layouts.app')

@section('title', 'Semua Berita - JURNALISTIK SPELAND')
@section('meta_description', 'Indeks seluruh liputan berita, artikel, dan dokumentasi resmi SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header Section -->
    <div class="border-b-2 border-blue-950 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-y-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Semua Berita & Publikasi
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kumpulan liputan fakta, artikel, dan pengumuman resmi SMP Negeri 9 Probolinggo.
            </p>
        </div>

        <!-- Filter bar -->
        <form method="GET" action="{{ route('articles.index') }}" class="flex items-center space-x-2">
            <select name="kategori" onchange="this.form.submit()" class="text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('kategori') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="urutan" onchange="this.form.submit()" class="text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                <option value="terbaru" {{ request('urutan') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="populer" {{ request('urutan') === 'populer' ? 'selected' : '' }}>Terpopuler</option>
            </select>
        </form>
    </div>

    <!-- Layout Grid with Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Articles Grid (8 cols) -->
        <div class="lg:col-span-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <div class="col-span-2 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <i data-lucide="newspaper" class="w-10 h-10 text-slate-400 mx-auto mb-2"></i>
                        <h3 class="text-base font-bold text-slate-700">Tidak ada artikel yang ditemukan</h3>
                        <p class="text-xs text-slate-500 mt-1">Silakan pilih kategori atau kata kunci lain.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>

        <!-- Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>

    </div>

</div>
@endsection
