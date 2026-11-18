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
                       placeholder="admin@speland.sch.id / username" 
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

        <!-- Development Quick Account Fill -->
        @if(app()->environment('local'))
            <div class="mt-6 pt-4 border-t border-dashed border-slate-200 bg-slate-50 p-3 rounded-lg text-xs" x-data>
                <span class="font-bold text-slate-700 block mb-2 text-center text-xs">
                    Akun Cepat (Development Demo):
                </span>
                <div class="grid grid-cols-2 gap-1.5 text-xs">
                    <button type="button" @click="document.getElementById('email').value='admin@speland.sch.id'; document.getElementById('password').value='password123'" class="bg-white border border-slate-300 px-2 py-1 rounded hover:bg-slate-100 text-left truncate">
                        <strong>Admin</strong> (Super Admin)
                    </button>
                    <button type="button" @click="document.getElementById('email').value='pemred@speland.sch.id'; document.getElementById('password').value='password123'" class="bg-white border border-slate-300 px-2 py-1 rounded hover:bg-slate-100 text-left truncate">
                        <strong>Pemred</strong> (Pim. Redaksi)
                    </button>
                    <button type="button" @click="document.getElementById('email').value='editor@speland.sch.id'; document.getElementById('password').value='password123'" class="bg-white border border-slate-300 px-2 py-1 rounded hover:bg-slate-100 text-left truncate">
                        <strong>Editor</strong> (Redaktur)
                    </button>
                    <button type="button" @click="document.getElementById('email').value='reporter@speland.sch.id'; document.getElementById('password').value='password123'" class="bg-white border border-slate-300 px-2 py-1 rounded hover:bg-slate-100 text-left truncate">
                        <strong>Reporter</strong> (Jurnalis)
                    </button>
                </div>
                <span class="block text-slate-400 text-2xs text-center mt-2 italic">Password default: password123</span>
            </div>
        @endif

    </div>
</div>
@endsection
