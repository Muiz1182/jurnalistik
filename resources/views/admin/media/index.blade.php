@extends('layouts.admin')

@section('title', 'Media Library - Meja Redaksi')
@section('page_title', 'Perpustakaan Media & Foto')

@section('content')
<div class="space-y-6" x-data="{ uploadModalOpen: false }">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Media Library</h2>
            <p class="text-xs text-slate-500">Koleksi foto liputan, grafis berita, dan aset visual redaksi.</p>
        </div>
        <button @click="uploadModalOpen = true" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="upload" class="w-4 h-4 mr-1.5"></i>
            <span>Unggah Foto Baru</span>
        </button>
    </div>

    <!-- Media Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($media as $item)
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs group relative">
                <div class="aspect-square bg-slate-100 overflow-hidden">
                    <img src="{{ $item->url }}" alt="{{ $item->caption }}" class="w-full h-full object-cover">
                </div>
                <div class="p-2 text-2xs">
                    <span class="font-bold text-slate-800 truncate block">{{ $item->filename }}</span>
                    <span class="text-slate-400 block">{{ round($item->file_size / 1024) }} KB</span>
                </div>
                <!-- Action Hover Overlay -->
                <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-2">
                    <button type="button" @click="navigator.clipboard.writeText('{{ $item->url }}'); alert('Tautan gambar berhasil disalin!')" class="p-2 bg-white text-slate-800 rounded-lg hover:bg-slate-100 shadow" title="Salin Tautan">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                    <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus media ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-6 py-12 text-center bg-white rounded-xl border border-dashed border-slate-200 p-8">
                <i data-lucide="image" class="w-10 h-10 text-slate-400 mx-auto mb-2"></i>
                <p class="text-xs text-slate-500 italic">Belum ada berkas media di perpustakaan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $media->links() }}
    </div>

    <!-- Modal Upload -->
    <div x-show="uploadModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="uploadModalOpen = false" class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-md w-full p-6">
            <h3 class="text-base font-extrabold text-slate-900 mb-3 flex items-center">
                <i data-lucide="upload-cloud" class="w-5 h-5 mr-2 text-blue-900"></i>
                Unggah Berkas Media
            </h3>
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Gambar (Maks 5MB) *</label>
                    <input type="file" name="file" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Keterangan / Caption</label>
                    <input type="text" name="caption" placeholder="Keterangan gambar..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alt Text (Aksesibilitas)</label>
                    <input type="text" name="alt_text" placeholder="Deskripsi gambar untuk pembaca tuna netra..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="uploadModalOpen = false" class="px-3.5 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 font-bold bg-blue-950 text-white rounded-lg shadow-sm">Unggah</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
