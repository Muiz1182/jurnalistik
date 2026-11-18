@extends('layouts.admin')

@section('title', 'Edit Album: ' . $gallery->title)
@section('page_title', 'Kelola Album & Foto Galeri')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">
    
    <!-- Edit Metadata Form -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs">
        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Informasi Album</h2>
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Album *</label>
                <input type="text" name="title" required value="{{ old('title', $gallery->title) }}" class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-sm font-semibold text-slate-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori / Topik *</label>
                    <input type="text" name="category" value="{{ old('category', $gallery->category) }}" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ganti Foto Sampul</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full text-xs text-slate-500">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Album</label>
                <textarea name="description" rows="2" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div class="border-t border-slate-200 pt-4">
                <label class="block font-bold text-slate-700 mb-1">Tambah Foto ke Album (Multi Upload)</label>
                <input type="file" name="photos[]" multiple accept="image/*" class="w-full text-xs text-slate-500">
            </div>

            <div class="flex justify-end pt-3">
                <button type="submit" class="px-4 py-2 font-bold bg-blue-950 text-white rounded-lg shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <!-- Photos List in Album -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs">
        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">
            Daftar Foto dalam Album ({{ $gallery->photos->count() }})
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @forelse($gallery->photos as $photo)
                <div class="bg-slate-50 border border-slate-200 rounded-lg overflow-hidden group relative">
                    <img src="{{ $photo->image_url }}" alt="" class="aspect-square object-cover w-full">
                    <div class="p-2 text-2xs text-slate-600 line-clamp-1">
                        {{ $photo->caption ?: 'Tanpa keterangan' }}
                    </div>
                    <form action="{{ route('admin.gallery-photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 bg-red-600 text-white rounded-md shadow hover:bg-red-700">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic py-4 col-span-4 text-center">Belum ada foto dalam album ini.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
