@extends('layouts.app')

@section('title', 'Struktur Dewan Redaksi - JURNALISTIK SPELAND')
@section('meta_description', 'Susunan struktur organisasi dewan redaksi dan pembina Jurnalistik SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <div class="border-b-2 border-blue-950 pb-5">
        <span class="text-xs font-bold text-red-600 uppercase tracking-wider block">Manajemen Organisasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">
            Struktur Redaksi Jurnalistik SPELAND
        </h1>
        <p class="text-sm text-slate-600 mt-2">
            Susunan dewan pengarah, pembina, redaktur pelaksana, dan reporter resmi SMP Negeri 9 Probolinggo.
        </p>
    </div>

    @foreach($members as $division => $divisionMembers)
        <section class="space-y-4">
            <h2 class="text-lg font-extrabold text-blue-950 uppercase tracking-wider border-b-2 border-blue-900 pb-2 flex items-center">
                <i data-lucide="users" class="w-5 h-5 mr-2 text-blue-900"></i>
                Divisi: {{ $division }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($divisionMembers as $member)
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs hover:shadow-sm transition flex items-center space-x-4">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-16 h-16 rounded-full object-cover shrink-0 border border-slate-200">
                        <div>
                            <h3 class="font-bold text-sm text-slate-900 leading-snug">{{ $member->name }}</h3>
                            <p class="text-xs font-semibold text-blue-900 mt-0.5">{{ $member->position }}</p>
                            @if($member->class_or_grade)
                                <span class="text-xs text-slate-500 mt-0.5 block">{{ $member->class_or_grade }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

</div>
@endsection
