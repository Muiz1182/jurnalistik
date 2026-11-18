@extends('layouts.admin')

@section('title', 'Kategori Berita - Meja Redaksi')
@section('page_title', 'Manajemen Kategori & Rubrik Berita')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, currentCat: {} }">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Kategori & Rubrik</h2>
            <p class="text-xs text-slate-500">Kelola rubrikasi berita dan penataan menu navigasi website.</p>
        </div>
        <button @click="addModalOpen = true" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $category)
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black uppercase px-2.5 py-0.5 rounded text-white" style="background-color: {{ $category->color }}">
                            {{ $category->name }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Urutan: #{{ $category->order }}</span>
                    </div>

                    <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                        {{ $category->description ?: 'Tidak ada deskripsi.' }}
                    </p>

                    <div class="flex items-center space-x-2 text-2xs text-slate-400 mt-3">
                        <span>{{ $category->articles_count }} artikel terbit</span>
                        <span>&bull;</span>
                        <span>{{ $category->show_in_navbar ? 'Tampil di Nav' : 'Tersembunyi di Nav' }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" 
                            @click="currentCat = {{ json_encode($category) }}; editModalOpen = true"
                            class="p-1.5 text-slate-600 hover:text-blue-900 rounded hover:bg-slate-50" 
                            title="Edit Kategori">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>
                    
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded hover:bg-slate-50" title="Hapus Kategori">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Tambah Kategori -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="addModalOpen = false" class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-md w-full p-6">
            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center">
                <i data-lucide="folder-plus" class="w-5 h-5 mr-2 text-blue-900"></i>
                Tambah Kategori Baru
            </h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kategori *</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Warna Badge (Hex) *</label>
                    <input type="color" name="color" value="#0F2C59" class="w-full h-10 bg-slate-50 border border-slate-300 rounded-lg p-1">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan Menu</label>
                    <input type="number" name="order" value="1" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs">
                </div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="show_in_navbar" value="1" checked class="rounded border-slate-300 text-blue-900">
                    <span class="font-semibold text-slate-800">Tampilkan di Menu Navigasi Utama</span>
                </label>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 font-bold bg-blue-950 text-white rounded-lg shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="editModalOpen = false" class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-md w-full p-6">
            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center">
                <i data-lucide="edit" class="w-5 h-5 mr-2 text-blue-900"></i>
                Edit Kategori
            </h3>
            <form :action="'{{ url('admin/categories') }}/' + currentCat.id" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kategori *</label>
                    <input type="text" name="name" :value="currentCat.name" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Warna Badge (Hex) *</label>
                    <input type="color" name="color" :value="currentCat.color" class="w-full h-10 bg-slate-50 border border-slate-300 rounded-lg p-1">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" :value="currentCat.description" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan Menu</label>
                    <input type="number" name="order" :value="currentCat.order" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs">
                </div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="show_in_navbar" value="1" :checked="currentCat.show_in_navbar" class="rounded border-slate-300 text-blue-900">
                    <span class="font-semibold text-slate-800">Tampilkan di Menu Navigasi Utama</span>
                </label>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 font-bold bg-blue-950 text-white rounded-lg shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
