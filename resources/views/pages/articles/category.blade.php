@extends('layouts.app')

@section('title', 'Berita ' . $category->name . ' - JURNALISTIK SPELAND')
@section('meta_description', $category->description ?: 'Arsip berita dan liputan kategori ' . $category->name . ' SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Category Header Banner -->
    <div class="border-b-2 border-blue-950 pb-4 mb-6">
        <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
            <a href="{{ route('home') }}" class="hover:text-blue-900">Beranda</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-800 font-semibold">Kategori</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight uppercase">
            {{ $category->name }}
        </h1>
        @if($category->description)
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-3xl">
                {{ $category->description }}
            </p>
        @endif
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-8 space-y-4">
            @forelse($articles as $article)
                <x-article-card :article="$article" layout="horizontal" />
            @empty
                <div class="py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <i data-lucide="folder-open" class="w-10 h-10 text-slate-400 mx-auto mb-2"></i>
                    <h3 class="text-base font-bold text-slate-700">Belum ada berita di kategori ini</h3>
                    <p class="text-xs text-slate-500 mt-1">Tim redaksi sedang menyiapkan liputan terbaru.</p>
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
