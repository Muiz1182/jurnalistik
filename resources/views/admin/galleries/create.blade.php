@extends('layouts.admin')

@section('title', 'Buat Album Galeri Baru - Meja Redaksi')
@section('page_title', 'Buat Album Galeri Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Album *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Upacara Hari Pahlawan 2026" class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori / Topik Kegiatan *</label>
                    <select name="category" required class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800">
                        <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                        <option value="Upacara & Apel">Upacara & Apel</option>
                        <option value="Prestasi & Lomba">Prestasi & Lomba</option>
                        <option value="Pramuka">Pramuka</option>
                        <option value="Adiwiyata">Adiwiyata</option>
                        <option value="P5 Kurikulum Merdeka">P5 Kurikulum Merdeka</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Foto Sampul Utama (Maks 3MB)</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-900">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Album</label>
                <textarea name="description" rows="3" placeholder="Keterangan singkat mengenai rangkaian kegiatan dalam album ini..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('description') }}</textarea>
            </div>

            <div class="border-t border-slate-200 pt-4">
                <label class="block font-bold text-slate-700 mb-1">Unggah Sekaligus Foto-Foto Album (Multi Upload)</label>
                <input type="file" name="photos[]" multiple accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-slate-100 file:text-slate-800">
                <p class="text-2xs text-slate-400 mt-1">Anda dapat memilih beberapa foto sekaligus untuk langsung dimasukkan ke album.</p>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</a>
                <button type="submit" class="px-5 py-2.5 font-bold bg-blue-950 hover:bg-blue-900 text-white rounded-lg shadow-sm">Simpan Album</button>
            </div>
        </form>
    </div>
</div>
@endsection
