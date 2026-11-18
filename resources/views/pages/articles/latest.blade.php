@extends('layouts.app')

@section('title', 'Berita Terbaru - JURNALISTIK SPELAND')
@section('meta_description', 'Laporan liputan terkini dan teraktual dari tim redaksi Jurnalistik SPELAND.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-blue-950 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
            <span class="w-3 h-3 bg-blue-900 rounded-xs mr-2.5"></span>
            Berita Terkini & Terbaru
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Kronologi publikasi informasi terkini dari seluruh sudut kegiatan SMP Negeri 9 Probolinggo.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Main Articles (8 cols) -->
        <div class="lg:col-span-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <div class="col-span-2 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <i data-lucide="newspaper" class="w-10 h-10 text-slate-400 mx-auto mb-2"></i>
                        <p class="text-xs text-slate-500 italic">Belum ada berita terbaru saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>

        <!-- Consistent Right Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>
    </div>

</div>
@endsection
