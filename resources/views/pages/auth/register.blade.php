@extends('layouts.app')

@section('title', 'Pendaftaran Akun Pembaca - JURNALISTIK SPELAND')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
        
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Daftar Akun Pembaca
            </h2>
            <p class="mt-1 text-xs text-slate-500">
                Bergabunglah untuk menyimpan artikel favorit dan mengirimkan komentar.
            </p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg p-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="space-y-4" action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                <input name="name" type="text" required value="{{ old('name') }}" placeholder="Contoh: Muhammad Akbar" class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Username *</label>
                <input name="username" type="text" required value="{{ old('username') }}" placeholder="akbar_speland" class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                <input name="email" type="email" required value="{{ old('email') }}" placeholder="email@gmail.com" class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi *</label>
                <input name="password" type="password" required placeholder="Minimal 8 karakter" class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi *</label>
                <input name="password_confirmation" type="password" required placeholder="Ulangi kata sandi" class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <button type="submit" class="w-full bg-blue-950 hover:bg-blue-900 text-white font-bold text-sm py-2.5 rounded-lg transition shadow-sm mt-2">
                Daftar Sekarang
            </button>
        </form>

        <div class="border-t border-slate-200 pt-4 text-center">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-blue-900 hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
