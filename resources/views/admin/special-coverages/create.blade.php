@extends('layouts.admin')

@section('title', 'Buat Liputan Khusus Baru - Meja Redaksi')
@section('page_title', 'Buat Serial Liputan Khusus')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs">
        <form action="{{ route('admin.special-coverages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Liputan Khusus *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Serial Investigasi: Jejak Prestasi Adiwiyata Mandiri 2026" class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Subjudul / Lead</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Penjelasan singkat fokus serial liputan..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap Serial</label>
                <textarea name="description" rows="3" placeholder="Latar belakang pentingnya liputan khusus ini..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Banner Gambar Utama</label>
                <input type="file" name="banner_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-900">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-2">Pilih Artikel yang Disematkan dalam Serial Ini</label>
                <div class="max-h-60 overflow-y-auto space-y-2 border border-slate-200 rounded-lg p-3 bg-slate-50">
                    @foreach($articles as $art)
                        <label class="flex items-center space-x-2 text-xs text-slate-800 cursor-pointer hover:bg-white p-1 rounded">
                            <input type="checkbox" name="article_ids[]" value="{{ $art->id }}" class="rounded border-slate-300 text-blue-900">
                            <span class="font-medium truncate">[{{ $art->category->name }}] {{ $art->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200">
                <a href="{{ route('admin.special-coverages.index') }}" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</a>
                <button type="submit" class="px-5 py-2.5 font-bold bg-blue-950 hover:bg-blue-900 text-white rounded-lg shadow-sm">Simpan Liputan Khusus</button>
            </div>
        </form>
    </div>
</div>
@endsection
