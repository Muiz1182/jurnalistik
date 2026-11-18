@extends('layouts.app')

@section('title', 'Masuk Redaksi & Pembaca - JURNALISTIK SPELAND')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
        
        <div class="text-center">
            <div class="w-12 h-12 bg-blue-950 text-white rounded-xl flex items-center justify-center font-extrabold text-xl mx-auto shadow-md border-b-2 border-red-600">
                JS
            </div>
            <h2 class="mt-4 text-2xl font-extrabold text-slate-900 tracking-tight">
                Masuk ke Portal SPELAND
            </h2>
            <p class="mt-1 text-xs text-slate-500">
                Gunakan akun redaksi atau pembaca untuk mengakses fitur lengkap.
            </p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg p-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="mt-6 space-y-4" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                    Email atau Username
                </label>
                <input id="email" 
                       name="email" 
                       type="text" 
                       required 
                       value="{{ old('email') }}" 
                       placeholder="email@jurnalistik.mmaproduction.com / username" 
                       class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-xs font-bold text-slate-700">
                        Kata Sandi
                    </label>
                </div>
                <input id="password" 
                       name="password" 
                       type="password" 
                       required 
                       placeholder="••••••••" 
                       class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-900 focus:ring-blue-900 mr-2">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-950 hover:bg-blue-900 text-white font-bold text-sm py-2.5 rounded-lg transition shadow-sm">
                Masuk Sekarang
            </button>
        </form>

        <div class="border-t border-slate-200 pt-4 text-center">
            <p class="text-xs text-slate-500">
                Belum memiliki akun pembaca? 
                <a href="{{ route('register') }}" class="font-bold text-blue-900 hover:underline">
                    Daftar di sini
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
