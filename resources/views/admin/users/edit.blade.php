@extends('layouts.admin')

@section('title', 'Edit Pengguna - Meja Redaksi')
@section('page_title', 'Perbarui Data Pengguna')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Edit Profil: {{ $user->name }}</h2>
            <p class="text-xs text-slate-500">Perbarui informasi jabatan, peranan, atau status akun pengguna.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-600 hover:text-blue-950 flex items-center">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
            Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs rounded">
                <p class="font-bold mb-1">Terjadi kesalahan validasi:</p>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
            </div>

            <div>
                <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username *</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white"
                    placeholder="Kosongkan jika tetap">
            </div>

            <div>
                <label for="role_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Role / Peran Akses *</label>
                <select name="role_id" id="role_id" required
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }} ({{ $role->slug }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jabatan / Gelar Redaksi</label>
                <input type="text" name="title" id="title" value="{{ old('title', $user->title) }}"
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon / WhatsApp</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
            </div>

            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Akun *</label>
                <select name="status" id="status" required
                    class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Ditangguhkan (Suspended)</option>
                </select>
            </div>
        </div>

        <div>
            <label for="bio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Biografi Singkat</label>
            <textarea name="bio" id="bio" rows="3"
                class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-2xs transition">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>
@endsection
