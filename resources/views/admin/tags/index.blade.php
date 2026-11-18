@extends('layouts.admin')

@section('title', 'Tag & Topik Berita - Meja Redaksi')
@section('page_title', 'Manajemen Tag & Topik')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false }">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Tag Berita</h2>
            <p class="text-xs text-slate-500">Kelola kata kunci topik peliputan untuk memudahkan pencarian berita terkait.</p>
        </div>
        <button @click="addModalOpen = true" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Tambah Tag</span>
        </button>
    </div>

    <!-- Tags List Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <table class="w-full text-left text-xs divide-y divide-slate-200">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase">
                <tr>
                    <th class="px-5 py-3">Nama Tag</th>
                    <th class="px-5 py-3">Slug</th>
                    <th class="px-5 py-3 text-center">Jumlah Artikel</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                @forelse($tags as $tag)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3 font-bold text-blue-950">#{{ $tag->name }}</td>
                        <td class="px-5 py-3 text-slate-400 font-mono text-2xs">{{ $tag->slug }}</td>
                        <td class="px-5 py-3 text-center font-bold">{{ $tag->articles_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-slate-400 italic">Belum ada tag yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-200">
            {{ $tags->links() }}
        </div>
    </div>

    <!-- Modal Tambah Tag -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="addModalOpen = false" class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-sm w-full p-6">
            <h3 class="text-base font-extrabold text-slate-900 mb-3 flex items-center">
                <i data-lucide="hash" class="w-5 h-5 mr-1.5 text-blue-900"></i>
                Tambah Tag Topik
            </h3>
            <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Tag *</label>
                    <input type="text" name="name" required placeholder="Contoh: SeniBudaya" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="addModalOpen = false" class="px-3.5 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 font-bold bg-blue-950 text-white rounded-lg shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
