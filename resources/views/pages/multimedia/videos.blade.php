@extends('layouts.app')

@section('title', 'Video Jurnalistik - JURNALISTIK SPELAND')
@section('meta_description', 'Kanal publikasi dokumentasi video, liputan lapangan, dan profil SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-red-600 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
            <i data-lucide="video" class="w-6 h-6 mr-2 text-red-600"></i>
            Video Jurnalistik & Liputan Lapangan
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Produksi konten multimedia visual dan siaran langsung kegiatan SMP Negeri 9 Probolinggo.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col justify-between">
                <div class="aspect-video bg-slate-900 relative">
                    <iframe class="w-full h-full" 
                            src="{{ $video->embed_url }}" 
                            title="{{ $video->title }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4 flex-grow flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-red-600 uppercase tracking-wider block mb-1">
                            {{ $video->category }}
                        </span>
                        <h2 class="font-bold text-base text-slate-900 leading-snug line-clamp-2">
                            {{ $video->title }}
                        </h2>
                        @if($video->description)
                            <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                {{ $video->description }}
                            </p>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $video->published_at ? $video->published_at->locale('id')->isoFormat('D MMM Y') : '' }}</span>
                        <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener" class="text-red-600 font-semibold hover:underline flex items-center">
                            <span>Tonton di YouTube</span>
                            <i data-lucide="external-link" class="w-3 h-3 ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500 italic">Belum ada video jurnalistik yang dimuat.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $videos->links() }}
    </div>

</div>
@endsection
