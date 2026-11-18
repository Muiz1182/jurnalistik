@extends('layouts.admin')

@section('title', 'Galeri Foto - Meja Redaksi')
@section('page_title', 'Manajemen Galeri & Album Foto')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Album Dokumentasi Foto</h2>
            <p class="text-xs text-slate-500">Kelola album foto kegiatan, upacara, dan dokumentasi sekolah.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Buat Album Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="aspect-[16/10] bg-slate-100 overflow-hidden relative">
                        <img src="{{ $gallery->cover_image_url }}" alt="" class="w-full h-full object-cover">
                        <span class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-2xs font-bold px-2 py-0.5 rounded">
                            {{ $gallery->photos_count }} Foto
                        </span>
                    </div>
                    <div class="p-4">
                        <span class="text-2xs font-bold text-blue-900 uppercase block mb-1">{{ $gallery->category }}</span>
                        <h3 class="font-bold text-sm text-slate-900 leading-snug line-clamp-2">
                            {{ $gallery->title }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $gallery->description }}</p>
                    </div>
                </div>

                <div class="p-4 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>{{ $gallery->created_at->locale('id')->isoFormat('D MMM Y') }}</span>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="p-1 text-slate-600 hover:text-blue-900" title="Edit Album">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus album ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-slate-400 hover:text-red-600" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center bg-white rounded-xl border border-dashed border-slate-200 p-8">
                <p class="text-xs text-slate-400 italic">Belum ada album galeri yang dibuat.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $galleries->links() }}
    </div>

</div>
@endsection
