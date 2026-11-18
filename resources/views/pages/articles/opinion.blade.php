@extends('layouts.app')

@section('title', 'Opini & Esai Murid - JURNALISTIK SPELAND')
@section('meta_description', 'Gagasan kritis, refleksi literasi, dan esai pendidikan karya murid serta guru SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-orange-600 pb-4 mb-6">
        <span class="text-xs font-extrabold uppercase tracking-wider text-orange-600 block">Kanal Pemikiran</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Opini, Esai & Cerita Inspiratif
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl">
            Ruang dialektika dan wadah kebebasan berekspresi positif bagi murid dan guru SMP Negeri 9 Probolinggo.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-8 space-y-6">
            @forelse($articles as $article)
                <article class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs hover:shadow-md transition">
                    <div class="flex items-center space-x-3 mb-3">
                        <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                        <div>
                            <h3 class="font-bold text-sm text-slate-900">{{ $article->author->name }}</h3>
                            <span class="text-xs text-slate-400 block">{{ $article->author->title ?? 'Penulis Opini' }}</span>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 hover:text-blue-900 transition leading-snug">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            &ldquo;{{ $article->title }}&rdquo;
                        </a>
                    </h2>

                    @if($article->subtitle)
                        <p class="text-xs sm:text-sm text-slate-600 italic mt-1 font-medium">
                            {{ $article->subtitle }}
                        </p>
                    @endif

                    <p class="text-xs sm:text-sm text-slate-700 mt-3 line-clamp-3 leading-relaxed">
                        {{ $article->excerpt }}
                    </p>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $article->published_at ? $article->published_at->locale('id')->isoFormat('dddd, D MMMM Y') : '' }}</span>
                        <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-900 font-bold hover:underline flex items-center">
                            <span>Baca Selengkapnya</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-500 italic">Belum ada karya opini yang dimuat.</p>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>

        <aside class="lg:col-span-4 space-y-6">
            <!-- Guidelines for Opini submission -->
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-5">
                <h4 class="font-bold text-sm text-orange-950 uppercase tracking-wider mb-2 flex items-center">
                    <i data-lucide="pen-tool" class="w-4 h-4 mr-1.5 text-orange-700"></i>
                    Kirim Esai & Opini Anda
                </h4>
                <p class="text-xs text-orange-900 leading-relaxed mb-3">
                    Seluruh murid dan guru SMPN 9 Probolinggo dapat mengirimkan karya tulisan opini dengan panjang 400 - 800 kata. Naskah akan dikurasi oleh tim editor sebelum diterbitkan.
                </p>
                <a href="{{ route('contact') }}" class="text-xs font-bold bg-orange-700 text-white px-3.5 py-2 rounded-lg hover:bg-orange-800 transition inline-block">
                    Petunjuk Pengiriman Naskah
                </a>
            </div>

            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>

    </div>

</div>
@endsection
