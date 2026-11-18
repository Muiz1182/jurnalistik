@extends('layouts.app')

@section('title', 'Daftar Bacaan Tersimpan - JURNALISTIK SPELAND')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-blue-950 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
            <i data-lucide="bookmark" class="w-6 h-6 mr-2 text-blue-900"></i>
            Daftar Bacaan Tersimpan
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Artikel dan liputan yang telah Anda tandai untuk dibaca kembali.
        </p>
    </div>

    @if($bookmarks->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($bookmarks as $b)
                <div class="relative group">
                    <x-article-card :article="$b->article" layout="horizontal" />
                    <form action="{{ route('articles.bookmark', $b->article) }}" method="POST" class="absolute top-5 right-5">
                        @csrf
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-1.5 rounded-lg border border-red-200 shadow-2xs transition" title="Hapus dari daftar bacaan">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bookmarks->links() }}
        </div>
    @else
        <div class="py-16 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
            <i data-lucide="bookmark-x" class="w-12 h-12 text-slate-400 mx-auto mb-3"></i>
            <h3 class="text-base font-bold text-slate-800">Belum ada artikel yang disimpan</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Temukan berita menarik di beranda dan klik tombol "Simpan Berita" untuk membacanya nanti.
            </p>
            <a href="{{ route('home') }}" class="mt-4 inline-flex items-center text-xs font-bold bg-blue-950 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition">
                Jelajahi Berita Sekarang
            </a>
        </div>
    @endif

</div>
@endsection
