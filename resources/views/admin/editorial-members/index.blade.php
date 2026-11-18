@extends('layouts.admin')

@section('title', 'Struktur Redaksi - Meja Redaksi')
@section('page_title', 'Pengelolaan Struktur Tim Redaksi')

@section('content')
<div class="space-y-6" x-data="{ addModal: false, editModal: false, activeMember: {} }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Dewan Redaksi & Pengurus Jurnalistik SPELAND</h2>
            <p class="text-xs text-slate-500">Kelola susunan pengurus pers sekolah yang tampil pada halaman publik struktur redaksi.</p>
        </div>
        <button @click="addModal = true" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center shrink-0">
            <i data-lucide="plus-circle" class="w-4 h-4 mr-1.5"></i>
            <span>Tambah Anggota Redaksi</span>
        </button>
    </div>

    <!-- Members Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <table class="w-full text-left text-xs divide-y divide-slate-200">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3.5 w-12 text-center">Urutan</th>
                    <th class="px-5 py-3.5">Nama & Foto</th>
                    <th class="px-5 py-3.5">Jabatan</th>
                    <th class="px-5 py-3.5">Divisi / Bidang</th>
                    <th class="px-5 py-3.5">Kelas / Status</th>
                    <th class="px-5 py-3.5 text-center">Status</th>
                    <th class="px-5 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                @forelse($members as $m)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5 text-center font-bold text-slate-400">
                            {{ $m->order }}
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center space-x-3">
                                @if($m->photo)
                                    <img src="{{ Str::startsWith($m->photo, 'http') ? $m->photo : asset('storage/' . $m->photo) }}" alt="" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($m->name, 0, 2) }}
                                    </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $m->name }}</span>
                                    @if($m->bio)
                                        <span class="text-2xs text-slate-400 line-clamp-1 block">{{ $m->bio }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 font-bold text-blue-950">
                            {{ $m->position }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-700 text-2xs font-semibold">
                                {{ $m->division }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">
                            {{ $m->class_or_grade ?: '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded text-2xs font-bold uppercase {{ $m->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" @click="activeMember = {{ json_encode($m) }}; editModal = true" class="p-1.5 text-slate-600 hover:text-blue-900 rounded" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.editorial-members.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus anggota redaksi ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-slate-400 text-xs">
                            Belum ada anggota redaksi yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($members->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $members->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Anggota -->
    <div x-show="addModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addModal = false" class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm font-bold text-slate-800">Tambah Anggota Redaksi Baru</h3>
                <button @click="addModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.editorial-members.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Nama pengurus">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jabatan *</label>
                        <input type="text" name="position" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Contoh: Pemimpin Redaksi">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Divisi / Bidang *</label>
                        <input type="text" name="division" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Contoh: Dewan Pembina, Redaksi">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kelas / Keterangan</label>
                        <input type="text" name="class_or_grade" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Contoh: Kelas 9A / Guru">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Urutan</label>
                        <input type="number" name="order" value="1" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Anggota (Opsional)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-950 hover:file:bg-blue-100">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Biografi Singkat</label>
                    <textarea name="bio" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Pengalaman atau deskripsi tugas..."></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="addModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg font-bold">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Anggota -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="editModal = false" class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm font-bold text-slate-800">Edit Anggota Redaksi</h3>
                <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/editorial-members') }}/' + activeMember.id" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" x-model="activeMember.name" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jabatan *</label>
                        <input type="text" name="position" x-model="activeMember.position" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Divisi / Bidang *</label>
                        <input type="text" name="division" x-model="activeMember.division" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kelas / Keterangan</label>
                        <input type="text" name="class_or_grade" x-model="activeMember.class_or_grade" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Urutan</label>
                        <input type="number" name="order" x-model="activeMember.order" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto (Kosongkan jika tetap)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-950 hover:file:bg-blue-100">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Biografi Singkat</label>
                    <textarea name="bio" rows="2" x-model="activeMember.bio" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900"></textarea>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" :checked="activeMember.is_active" class="rounded text-blue-900 focus:ring-blue-900">
                    <label for="edit_is_active" class="font-bold text-slate-700">Tampilkan di Halaman Struktur Publik</label>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg font-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
