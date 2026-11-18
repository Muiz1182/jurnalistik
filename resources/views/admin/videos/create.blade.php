@extends('layouts.admin')

@section('title', 'Tambah Video Baru - Meja Redaksi')
@section('page_title', 'Tambah Video Jurnalistik Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs">
        <form action="{{ route('admin.videos.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Video *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Judul liputan video..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Tautan YouTube (URL) *</label>
                <input type="url" name="youtube_url" required value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
                <span class="text-2xs text-slate-400 mt-1 block">ID video akan diekstrak secara otomatis oleh sistem.</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Video *</label>
                    <input type="text" name="category" value="{{ old('category', 'Liputan Khusus') }}" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                <textarea name="description" rows="3" placeholder="Uraian isi dan narasumber video..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200">
                <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</a>
                <button type="submit" class="px-5 py-2.5 font-bold bg-blue-950 hover:bg-blue-900 text-white rounded-lg shadow-sm">Simpan Video</button>
            </div>
        </form>
    </div>
</div>
@endsection
