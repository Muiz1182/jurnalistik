@extends('layouts.app')

@section('title', 'Podcast SPELAND - JURNALISTIK SPELAND')
@section('meta_description', 'Bincang santai, edukatif, dan inspiratif bersama narasumber berprestasi SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-red-600 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
            <i data-lucide="mic" class="w-6 h-6 mr-2 text-red-600"></i>
            Podcast SPELAND
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Program gelar wicara audio-visual resmi SMPN 9 Probolinggo yang mengupas tuntas cerita prestasi, literasi, dan dinamika remaja sekolah.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($podcasts as $podcast)
            <article class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    @if($podcast->youtube_id)
                        <div class="aspect-video bg-slate-900">
                            <iframe class="w-full h-full" 
                                    src="{{ $podcast->embed_url }}" 
                                    title="{{ $podcast->title }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <div class="aspect-[16/9] bg-slate-800 flex items-center justify-center p-6 text-white text-center">
                            <div>
                                <i data-lucide="radio" class="w-10 h-10 mx-auto mb-2 text-red-400"></i>
                                <span class="text-xs uppercase tracking-wider text-slate-300 font-bold">Audio Podcast</span>
                            </div>
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="flex items-center justify-between text-xs font-bold text-red-600 mb-2">
                            <span>EPISODE {{ $podcast->episode_number }}</span>
                            @if($podcast->duration)
                                <span class="text-slate-400 font-medium flex items-center">
                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                    {{ $podcast->duration }}
                                </span>
                            @endif
                        </div>

                        <h2 class="font-bold text-base sm:text-lg text-slate-900 leading-snug">
                            {{ $podcast->title }}
                        </h2>

                        <div class="mt-2 space-y-1 text-xs text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <p><strong>Host:</strong> {{ $podcast->host }}</p>
                            @if($podcast->guest)
                                <p><strong>Narasumber:</strong> {{ $podcast->guest }}</p>
                            @endif
                        </div>

                        @if($podcast->description)
                            <p class="text-xs text-slate-600 mt-3 leading-relaxed line-clamp-3">
                                {{ $podcast->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>{{ $podcast->published_at ? $podcast->published_at->locale('id')->isoFormat('D MMMM Y') : '' }}</span>
                    @if($podcast->youtube_url)
                        <a href="{{ $podcast->youtube_url }}" target="_blank" rel="noopener" class="text-red-600 font-bold hover:underline flex items-center">
                            <span>Buka di YouTube</span>
                            <i data-lucide="external-link" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-span-2 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500 italic">Belum ada episode podcast yang diterbitkan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $podcasts->links() }}
    </div>

</div>
@endsection
