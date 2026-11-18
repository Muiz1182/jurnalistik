@extends('layouts.admin')

@section('title', 'Video Liputan - Meja Redaksi')
@section('page_title', 'Manajemen Video & Siaran Lapangan')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Video Liputan</h2>
            <p class="text-xs text-slate-500">Kelola video kegiatan sekolah yang terintegrasi dengan YouTube embed.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Tambah Video Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="aspect-video bg-slate-900">
                        <iframe class="w-full h-full" src="{{ $video->embed_url }}" title="{{ $video->title }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="p-4">
                        <span class="text-2xs font-bold text-red-600 uppercase block mb-1">{{ $video->category }}</span>
                        <h3 class="font-bold text-sm text-slate-900 leading-snug line-clamp-2">{{ $video->title }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $video->description }}</p>
                    </div>
                </div>

                <div class="p-4 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>{{ $video->published_at ? $video->published_at->locale('id')->isoFormat('D MMM Y') : '' }}</span>
                    <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center bg-white rounded-xl border border-dashed border-slate-200 p-8">
                <p class="text-xs text-slate-400 italic">Belum ada video yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $videos->links() }}
    </div>

</div>
@endsection
