@extends('layouts.app')

@section('title', 'Struktur Dewan Redaksi - JURNALISTIK SPELAND')
@section('meta_description', 'Susunan struktur organisasi dewan redaksi dan pembina Jurnalistik SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Struktur Redaksi</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-red-600 font-mono block mb-1">MANAJEMEN & PENGELOLA</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                Struktur Dewan Redaksi
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                Susunan dewan pembina sekolah, pemimpin redaksi, editor, fotografer, dan reporter resmi SMP Negeri 9 Probolinggo.
            </p>
        </div>
    </div>

    @forelse($members as $division => $divisionMembers)
        <section class="space-y-4">
            <div class="flex items-center justify-between pb-2.5 border-b-2 border-slate-900">
                <h2 class="text-xs sm:text-sm font-black text-slate-950 uppercase tracking-wider flex items-center">
                    <span class="w-2.5 h-2.5 bg-blue-900 rounded-xs mr-2"></span>
                    Divisi: {{ $division }}
                </h2>
                <span class="text-3xs font-mono text-slate-400 font-semibold">{{ $divisionMembers->count() }} Anggota</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                @foreach($divisionMembers as $member)
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs hover:shadow-sm transition flex items-center space-x-4">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-14 h-14 rounded-full object-cover shrink-0 border border-slate-200">
                        <div class="min-w-0">
                            <h3 class="font-bold text-xs sm:text-sm text-slate-900 leading-snug truncate">{{ $member->name }}</h3>
                            <p class="text-2xs font-semibold text-blue-900 mt-0.5 truncate">{{ $member->position }}</p>
                            @if($member->class_or_grade)
                                <span class="text-3xs text-slate-500 mt-0.5 block truncate">{{ $member->class_or_grade }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @empty
        <div class="bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-500 space-y-3 shadow-2xs">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-900 flex items-center justify-center mx-auto shadow-2xs">
                <i data-lucide="users" class="w-7 h-7"></i>
            </div>
            <h3 class="font-serif font-bold text-base text-slate-900">Susunan Redaksi Dalam Tahap Pembaruan</h3>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                Daftar pengurus dan dewan redaksi pelajar SMP Negeri 9 Probolinggo sedang dalam kurasi administratif dan akan segera diumumkan.
            </p>
            <div class="pt-2">
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition border border-slate-200">
                    <i data-lucide="home" class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    @endforelse

</div>
@endsection
