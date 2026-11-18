@extends('layouts.app')

@section('title', 'Galeri Foto Jurnalistik - JURNALISTIK SPELAND')
@section('meta_description', 'Dokumentasi visual dan album fotografi kegiatan resmi SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-blue-950 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
            <i data-lucide="camera" class="w-6 h-6 mr-2 text-blue-900"></i>
            Galeri Foto Jurnalistik
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Merekam setiap momen bersejarah, kehangatan kegiatan, dan ekspresi prestasi murid melalui lensa kamera.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs hover:shadow-md transition">
                <a href="{{ route('multimedia.gallery.show', $gallery->slug) }}" class="block aspect-[16/10] overflow-hidden bg-slate-100 relative">
                    <img src="{{ $gallery->cover_image_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-xs font-bold px-2.5 py-1 rounded-md flex items-center shadow">
                        <i data-lucide="image" class="w-3.5 h-3.5 mr-1.5"></i>
                        {{ $gallery->photos_count }} Foto
                    </span>
                    <span class="absolute top-3 left-3 bg-blue-950 text-white text-xs font-bold uppercase px-2.5 py-1 rounded shadow">
                        {{ $gallery->category }}
                    </span>
                </a>
                <div class="p-4">
                    <h2 class="font-bold text-base text-slate-900 group-hover:text-blue-900 transition leading-snug line-clamp-2">
                        <a href="{{ route('multimedia.gallery.show', $gallery->slug) }}">
                            {{ $gallery->title }}
                        </a>
                    </h2>
                    @if($gallery->description)
                        <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                            {{ $gallery->description }}
                        </p>
                    @endif
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $gallery->created_at->locale('id')->isoFormat('D MMMM Y') }}</span>
                        <span class="font-semibold text-blue-900 group-hover:underline flex items-center">
                            Buka Album &rarr;
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500 italic">Belum ada album foto yang diterbitkan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $galleries->links() }}
    </div>

</div>
@endsection
