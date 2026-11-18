@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Meja Redaksi')
@section('page_title', 'Manajemen Pengguna & Hak Akses (RBAC)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Pengguna Sistem</h2>
            <p class="text-xs text-slate-500">Kelola akun redaksi, reporter, editor, dan pembaca terdaftar.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center shrink-0">
            <i data-lucide="user-plus" class="w-4 h-4 mr-1.5"></i>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <table class="w-full text-left text-xs divide-y divide-slate-200">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase">
                <tr>
                    <th class="px-5 py-3.5">Nama & Profil</th>
                    <th class="px-5 py-3.5">Username / Email</th>
                    <th class="px-5 py-3.5">Role / Jabatan</th>
                    <th class="px-5 py-3.5 text-center">Status</th>
                    <th class="px-5 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $user->name }}</span>
                                    <span class="text-2xs text-slate-400 block">{{ $user->title ?: 'Staf' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="font-bold text-blue-950 block">{{ $user->username }}</span>
                            <span class="text-slate-400 block">{{ $user->email }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $roleBadges = [
                                    'super-admin' => 'bg-purple-100 text-purple-900',
                                    'pemimpin-redaksi' => 'bg-blue-100 text-blue-900',
                                    'editor' => 'bg-emerald-100 text-emerald-900',
                                    'reporter' => 'bg-amber-100 text-amber-900',
                                    'fotografer' => 'bg-pink-100 text-pink-900',
                                    'pembaca' => 'bg-slate-100 text-slate-700',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full font-bold text-2xs uppercase tracking-wider {{ $roleBadges[$user->role->slug ?? 'pembaca'] ?? 'bg-slate-100' }}">
                                {{ $user->role->name ?? 'Pembaca' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded text-2xs font-bold uppercase {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-slate-600 hover:text-blue-900 rounded" title="Edit Pengguna">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna ini?')" class="inline">
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
                @endforeach
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
