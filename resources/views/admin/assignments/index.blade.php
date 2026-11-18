@extends('layouts.admin')

@section('title', 'Penugasan Liputan - Meja Redaksi')
@section('page_title', 'Sistem Penugasan Liputan Jurnalistik')

@section('content')
<div class="space-y-6" x-data="{ addModal: false, statusModal: false, activeAssignment: {} }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-slate-800">
                @if(auth()->user()->isPemimpinRedaksi())
                    Daftar Agenda & Penugasan Liputan Redaksi
                @else
                    Agenda Tugas Liputan Saya
                @endif
            </h2>
            <p class="text-xs text-slate-500">
                @if(auth()->user()->isPemimpinRedaksi())
                    Instruksi dan koordinasi agenda liputan dari Kadiv untuk tim jurnalistik sekolah.
                @else
                    Daftar agenda penugasan liputan yang diberikan oleh Kadiv kepada Anda.
                @endif
            </p>
        </div>
        @if(auth()->user()->isPemimpinRedaksi())
            <button @click="addModal = true" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center shrink-0">
                <i data-lucide="send" class="w-4 h-4 mr-1.5"></i>
                <span>Tugaskan Liputan Baru</span>
            </button>
        @endif
    </div>

    <!-- Assignments Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <table class="w-full text-left text-xs divide-y divide-slate-200">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3.5">Judul & Brief Liputan</th>
                    <th class="px-5 py-3.5">Jurnalis Bertugas</th>
                    <th class="px-5 py-3.5">Pemberi Tugas</th>
                    <th class="px-5 py-3.5">Tenggat Waktu</th>
                    <th class="px-5 py-3.5 text-center">Status</th>
                    <th class="px-5 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                @forelse($assignments as $a)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5 max-w-sm">
                            <span class="font-bold text-slate-900 block">{{ $a->title }}</span>
                            <span class="text-slate-500 text-2xs line-clamp-2 mt-0.5">{{ $a->brief }}</span>
                            @if($a->notes)
                                <div class="mt-1 text-2xs text-amber-700 bg-amber-50 p-1.5 rounded border border-amber-200/50">
                                    <span class="font-bold">Catatan Redaksi:</span> {{ $a->notes }}
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center space-x-2">
                                <img src="{{ $a->reporter->avatar_url }}" alt="" class="w-6 h-6 rounded-full object-cover border border-slate-200">
                                <div>
                                    <span class="font-bold text-slate-800 block">{{ $a->reporter->name }}</span>
                                    <span class="text-2xs text-slate-400 block">{{ $a->reporter->title ?: 'Reporter' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">
                            {{ $a->assignedBy->name ?? 'Redaksi' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">
                            @if($a->deadline)
                                <span class="font-semibold {{ $a->deadline->isPast() ? 'text-red-600' : 'text-slate-700' }}">
                                    {{ $a->deadline->translatedFormat('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @php
                                $statusStyles = [
                                    'assigned' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'in_progress' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'submitted' => 'bg-purple-50 text-purple-700 border border-purple-200',
                                    'completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    'cancelled' => 'bg-slate-100 text-slate-500 border border-slate-200',
                                ];
                                $statusLabels = [
                                    'assigned' => 'Ditugaskan',
                                    'in_progress' => 'Proses Liputan',
                                    'submitted' => 'Naskah Diserahkan',
                                    'completed' => 'Selesai / Terbit',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="px-2 py-0.5 rounded text-2xs font-bold uppercase tracking-wider {{ $statusStyles[$a->status] ?? 'bg-slate-100' }}">
                                {{ $statusLabels[$a->status] ?? $a->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" @click="activeAssignment = {{ json_encode($a) }}; statusModal = true" class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-950 text-slate-700 text-2xs font-bold rounded transition flex items-center">
                                    <i data-lucide="edit-2" class="w-3.5 h-3.5 mr-1"></i>
                                    <span>Update Status</span>
                                </button>
                                @if(auth()->user()->isPemimpinRedaksi())
                                    <form action="{{ route('admin.assignments.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus penugasan liputan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-xs">
                            Belum ada penugasan liputan saat ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($assignments->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $assignments->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Tugas -->
    <div x-show="addModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addModal = false" class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm font-bold text-slate-800">Tugaskan Agenda Liputan</h3>
                <button @click="addModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.assignments.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Topik / Agenda Liputan *</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Contoh: Liputan Persiapan Ujian Sekolah Berbasis Komputer">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Brief & Petunjuk Liputan *</label>
                    <textarea name="brief" rows="4" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Jelaskan sudut pandang (angle), narasumber yang harus diwawancarai, lokasi, serta poin penting..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jurnalis Bertugas *</label>
                        <select name="reporter_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            <option value="">Pilih Jurnalis</option>
                            @foreach($reporters as $rep)
                                <option value="{{ $rep->id }}">{{ $rep->name }} ({{ $rep->role->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tenggat Waktu (Deadline)</label>
                        <input type="date" name="deadline" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="addModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg font-bold">Kirim Penugasan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Status Tugas -->
    <div x-show="statusModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="statusModal = false" class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm font-bold text-slate-800">Perbarui Status Penugasan</h3>
                <button @click="statusModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/assignments') }}/' + activeAssignment.id + '/status'" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status Liputan *</label>
                    <select name="status" x-model="activeAssignment.status" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                        <option value="assigned">Ditugaskan</option>
                        <option value="in_progress">Dalam Proses Liputan</option>
                        <option value="submitted">Naskah Diserahkan</option>
                        <option value="completed">Selesai / Terbit</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Tambahan / Hasil</label>
                    <textarea name="notes" rows="3" x-model="activeAssignment.notes" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Tambahkan informasi perkembangan liputan..."></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="statusModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg font-bold">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
