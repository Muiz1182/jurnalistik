@extends('layouts.admin')

@section('title', 'Tambah Episode Podcast - Meja Redaksi')
@section('page_title', 'Tambah Episode Podcast SPELAND')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs">
        <form action="{{ route('admin.podcasts.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Episode *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Ep. 3: Inspirasi Menulis Puisi Bersama..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Episode *</label>
                    <input type="number" name="episode_number" required value="{{ old('episode_number', $nextEpisode) }}" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Durasi (Menit:Detik)</label>
                    <input type="text" name="duration" placeholder="Contoh: 32:45" value="{{ old('duration') }}" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pembawa Acara (Host) *</label>
                    <input type="text" name="host" required value="{{ old('host', auth()->user()->name) }}" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Narasumber / Bintang Tamu</label>
                    <input type="text" name="guest" value="{{ old('guest') }}" placeholder="Nama & Gelar Narasumber" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Tautan YouTube Video Podcast</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi & Catatan Episode</label>
                <textarea name="description" rows="3" placeholder="Poin-poin pembahasan utama dalam episode ini..." class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200">
                <a href="{{ route('admin.podcasts.index') }}" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</a>
                <button type="submit" class="px-5 py-2.5 font-bold bg-blue-950 hover:bg-blue-900 text-white rounded-lg shadow-sm">Simpan Episode</button>
            </div>
        </form>
    </div>
</div>
@endsection
