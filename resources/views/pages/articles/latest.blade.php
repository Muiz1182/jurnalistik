@extends('layouts.app')

@section('title', 'Berita Terbaru - JURNALISTIK SPELAND')
@section('meta_description', 'Laporan liputan terkini dan teraktual dari tim redaksi Jurnalistik SPELAND.')

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
            <span class="text-slate-900 font-semibold">Berita Terbaru</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-blue-900 font-mono block mb-1">KRONOLOGI TERKINI</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                Berita Terkini & Terbaru
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                Arus publikasi informasi teraktual dari seluruh sudut kegiatan dan prestasi SMP Negeri 9 Probolinggo.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Main Articles (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <div class="col-span-2 bg-white border border-slate-200/90 rounded-2xl p-8 sm:p-12 text-center shadow-2xs space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-900 flex items-center justify-center mx-auto shadow-2xs">
                            <i data-lucide="clock" class="w-7 h-7"></i>
                        </div>
                        <div class="max-w-md mx-auto space-y-1.5">
                            <h2 class="text-base sm:text-lg font-serif font-bold text-slate-900">Belum Ada Berita Terbaru</h2>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-sans">
                                Seluruh liputan sedang dalam proses kurasi redaksi. Berita terbaru akan langsung tampil di sini.
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

            @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        <!-- Consistent Right Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>
    </div>

</div>
@endsection
