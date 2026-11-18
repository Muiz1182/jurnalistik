@extends('layouts.app')

@section('title', 'Berita Terpopuler - JURNALISTIK SPELAND')
@section('meta_description', 'Daftar berita paling banyak dibaca oleh masyarakat dan keluarga besar SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-blue-950 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
            <span class="w-3 h-3 bg-red-600 rounded-full mr-2.5"></span>
            Berita Terpopuler
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Artikel yang paling banyak menarik perhatian pembaca berdasarkan statistik kunjungan 30 hari terakhir.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $index => $article)
            <div class="relative">
                <div class="absolute -top-3 -left-3 z-10 w-9 h-9 rounded-full bg-blue-950 text-white font-black text-sm flex items-center justify-center shadow-md border-2 border-white">
                    #{{ $articles->firstItem() + $index }}
                </div>
                <x-article-card :article="$article" />
            </div>
        @empty
            <div class="col-span-3 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500 italic">Belum ada data berita populer.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $articles->links() }}
    </div>

</div>
@endsection
