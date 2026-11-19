@extends('layouts.app')

@section('title', 'Rubrik ' . $category->name . ' - JURNALISTIK SPELAND')
@section('meta_description', $category->description ?: 'Arsip berita dan liputan rubrik ' . $category->name . ' SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <!-- Category Header Masthead -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <a href="{{ route('articles.index') }}" class="hover:text-blue-900 transition">Berita</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">{{ $category->name }}</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-1 border-t border-slate-100">
            <div>
                <div class="flex items-center space-x-2.5 mb-1.5">
                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $category->color ?: '#1E3A8A' }}"></span>
                    <span class="text-3xs uppercase tracking-widest font-black text-slate-500 font-mono">RUBRIK RESMI SPELAND</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                    {{ $category->name }}
                </h1>
                @if($category->description)
                    <p class="text-xs sm:text-sm text-slate-600 mt-2 max-w-2xl leading-relaxed">
                        {{ $category->description }}
                    </p>
                @endif
            </div>

            <div class="shrink-0 flex sm:flex-col sm:items-end justify-between text-2xs text-slate-500 bg-slate-50 sm:bg-transparent p-3 sm:p-0 rounded-xl">
                <span class="font-bold text-slate-900 text-sm sm:text-base font-mono">{{ $articles->total() }}</span>
                <span class="text-slate-500 uppercase tracking-wider text-3xs font-semibold">Naskah Terbit</span>
            </div>
        </div>
    </div>

    <!-- Main Content & Sidebar Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Articles Feed (8 Cols) -->
        <div class="lg:col-span-8 space-y-5">
            @forelse($articles as $article)
                <x-article-card :article="$article" layout="horizontal" />
            @empty
                <!-- Reassuring Editorial Empty State -->
                <div class="bg-white border border-slate-200/90 rounded-2xl p-8 sm:p-12 text-center shadow-2xs space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-900 flex items-center justify-center mx-auto shadow-2xs">
                        <i data-lucide="newspaper" class="w-7 h-7"></i>
                    </div>
                    
                    <div class="max-w-md mx-auto space-y-1.5">
                        <h2 class="text-base sm:text-lg font-serif font-bold text-slate-900">
                            Liputan Rubrik {{ $category->name }} Sedang Berjalan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-sans">
                            Tim reporter dan dewan redaksi sedang mempersiapkan materi liputan lapangan serta verifikasi fakta untuk rubrik ini. Naskah terverifikasi akan segera diterbitkan di sini.
                        </p>
                    </div>

                    <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('articles.index') }}" 
                           class="px-4 py-2.5 bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs rounded-xl transition shadow-2xs flex items-center">
                            <i data-lucide="layers" class="w-3.5 h-3.5 mr-1.5"></i>
                            <span>Jelajahi Semua Berita</span>
                        </a>
                        <a href="{{ route('home') }}" 
                           class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition flex items-center border border-slate-200">
                            <i data-lucide="home" class="w-3.5 h-3.5 mr-1.5"></i>
                            <span>Kembali ke Beranda</span>
                        </a>
                        @auth
                            @if(auth()->user()->canAccessDashboard())
                                <a href="{{ route('admin.articles.create') }}" 
                                   class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition shadow-2xs flex items-center">
                                    <i data-lucide="pen-tool" class="w-3.5 h-3.5 mr-1.5"></i>
                                    <span>Tulis Naskah Baru</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="pt-4">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar (4 Cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />

            <!-- Directory of Other Rubrics -->
            @php
                $otherRubriks = \App\Models\Category::where('is_active', true)
                    ->where('id', '!=', $category->id)
                    ->orderBy('order')
                    ->get();
            @endphp
            @if($otherRubriks->isNotEmpty())
                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-3.5">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-950 flex items-center">
                            <i data-lucide="compass" class="w-3.5 h-3.5 mr-1.5 text-blue-900"></i>
                            Rubrik Lainnya
                        </h3>
                        <span class="text-3xs text-slate-400 font-mono">{{ $otherRubriks->count() }} Rubrik</span>
                    </div>

                    <div class="space-y-1.5 text-xs font-semibold">
                        @foreach($otherRubriks as $or)
                            <a href="{{ route('articles.category', $or->slug) }}" 
                               class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200 group">
                                <span class="flex items-center space-x-2.5 truncate">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $or->color ?: '#1E3A8A' }}"></span>
                                    <span class="text-slate-700 group-hover:text-blue-950 truncate">{{ $or->name }}</span>
                                </span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300 group-hover:text-blue-900 group-hover:translate-x-0.5 transition-transform shrink-0"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>

    </div>

</div>
@endsection
