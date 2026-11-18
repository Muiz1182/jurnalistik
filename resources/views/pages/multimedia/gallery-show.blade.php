@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri Foto SPELAND')
@section('meta_description', $gallery->description ?: 'Dokumentasi album foto ' . $gallery->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{ lightboxOpen: false, activeImg: '', activeCaption: '', activePhotographer: '' }">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-blue-900">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <a href="{{ route('multimedia.galleries') }}" class="hover:text-blue-900">Galeri Foto</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <span class="text-slate-800 font-semibold truncate max-w-sm">{{ $gallery->title }}</span>
    </nav>

    <!-- Album Header -->
    <div class="border-b-2 border-blue-950 pb-5 mb-8">
        <div class="flex items-center gap-2 mb-2">
            <span class="bg-blue-950 text-white text-xs font-bold uppercase px-2.5 py-1 rounded">
                {{ $gallery->category }}
            </span>
            <span class="text-xs text-slate-400">
                {{ $gallery->photos->count() }} Dokumentasi Foto
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">
            {{ $gallery->title }}
        </h1>
        @if($gallery->description)
            <p class="text-sm text-slate-600 mt-2 max-w-3xl leading-relaxed">
                {{ $gallery->description }}
            </p>
        @endif
        <div class="flex items-center text-xs text-slate-400 mt-4 space-x-4">
            <span>Fotografer: <strong>{{ $gallery->user->name }}</strong></span>
            <span>&bull;</span>
            <span>Dipublikasikan: {{ $gallery->created_at->locale('id')->isoFormat('D MMMM Y') }}</span>
        </div>
    </div>

    <!-- Photos Grid (Lightbox triggers) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($gallery->photos as $photo)
            <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs hover:shadow-md transition">
                <div class="aspect-[4/3] bg-slate-100 overflow-hidden cursor-pointer relative"
                     @click="activeImg = '{{ $photo->image_url }}'; activeCaption = '{{ addslashes($photo->caption) }}'; activePhotographer = '{{ addslashes($photo->photographer) }}'; lightboxOpen = true">
                    <img src="{{ $photo->image_url }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <span class="bg-white/90 text-slate-900 rounded-full p-2.5 shadow">
                            <i data-lucide="zoom-in" class="w-5 h-5"></i>
                        </span>
                    </div>
                </div>
                @if($photo->caption)
                    <div class="p-3">
                        <p class="text-xs text-slate-700 leading-snug line-clamp-2">
                            {{ $photo->caption }}
                        </p>
                        @if($photo->photographer)
                            <span class="text-xs text-slate-400 mt-1 block">Foto: {{ $photo->photographer }}</span>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Lightbox Modal -->
    <div x-show="lightboxOpen" 
         x-cloak
         @keydown.escape.window="lightboxOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm">
        <div @click.away="lightboxOpen = false" class="relative max-w-4xl w-full bg-slate-900 rounded-xl overflow-hidden shadow-2xl border border-slate-800">
            <button @click="lightboxOpen = false" class="absolute top-4 right-4 z-10 text-white bg-slate-800/80 hover:bg-slate-700 p-2 rounded-full transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <div class="max-h-[75vh] flex items-center justify-center bg-black">
                <img :src="activeImg" class="max-h-[75vh] w-auto max-w-full object-contain">
            </div>
            <div class="p-4 bg-slate-900 text-white" x-show="activeCaption">
                <p class="text-sm font-medium" x-text="activeCaption"></p>
                <span class="text-xs text-slate-400 mt-1 block" x-show="activePhotographer" x-text="'Fotografer: ' + activePhotographer"></span>
            </div>
        </div>
    </div>

</div>
@endsection
