@extends('layouts.app')

@section('title', $coverage->title . ' - Liputan Khusus SPELAND')
@section('meta_description', $coverage->description ?: $coverage->subtitle)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-blue-900">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <a href="{{ route('multimedia.special-coverages') }}" class="hover:text-blue-900">Liputan Khusus</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <span class="text-slate-800 font-semibold truncate max-w-sm">{{ $coverage->title }}</span>
    </nav>

    <!-- Banner Headline -->
    <div class="relative rounded-2xl overflow-hidden bg-blue-950 text-white mb-10 shadow-lg">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ $coverage->banner_image_url }}" alt="{{ $coverage->title }}" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 p-6 sm:p-10 max-w-3xl">
            <span class="bg-red-600 text-white text-xs font-extrabold uppercase px-3 py-1 rounded tracking-wider inline-block mb-3">
                LIPUTAN KHUSUS
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                {{ $coverage->title }}
            </h1>
            @if($coverage->subtitle)
                <h2 class="text-base sm:text-lg text-blue-200 font-medium mt-2">
                    {{ $coverage->subtitle }}
                </h2>
            @endif
            @if($coverage->description)
                <p class="text-xs sm:text-sm text-slate-300 mt-4 leading-relaxed">
                    {{ $coverage->description }}
                </p>
            @endif
        </div>
    </div>

    <!-- Related Articles within Special Coverage -->
    <div>
        <div class="border-b-2 border-blue-950 pb-3 mb-6">
            <h2 class="text-xl font-extrabold text-slate-900 flex items-center">
                <i data-lucide="layers" class="w-5 h-5 mr-2 text-blue-900"></i>
                Rangkaian Laporan & Liputan Terkait ({{ $coverage->articles->count() }})
            </h2>
        </div>

        <div class="space-y-4">
            @forelse($coverage->articles as $art)
                <x-article-card :article="$art" layout="horizontal" />
            @empty
                <div class="py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-500 italic">Belum ada artikel yang disematkan dalam serial ini.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
