@extends('layouts.app')

@section('title', 'Liputan Khusus - JURNALISTIK SPELAND')
@section('meta_description', 'Laporan mendalam dan liputan tematik terpadu redaksi Jurnalistik SPELAND.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-blue-950 pb-4 mb-8">
        <span class="text-xs font-extrabold uppercase tracking-wider text-blue-900 block">Jurnalisme Mendalam</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Liputan Khusus & Serial Tematik
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Investigasi editorial, sorotan program unggulan, dan serial dokumentasi terpadu SMP Negeri 9 Probolinggo.
        </p>
    </div>

    <div class="space-y-8">
        @forelse($coverages as $cov)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition grid grid-cols-1 lg:grid-cols-12">
                <div class="lg:col-span-5 bg-slate-100 aspect-video lg:aspect-auto">
                    <img src="{{ $cov->banner_image_url }}" alt="{{ $cov->title }}" class="w-full h-full object-cover">
                </div>
                <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-red-600 uppercase tracking-wider block mb-2">
                            Liputan Khusus Redaksi &bull; {{ $cov->articles_count }} Artikel Terkait
                        </span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                            <a href="{{ route('multimedia.special-coverage.show', $cov->slug) }}" class="hover:text-blue-900 transition">
                                {{ $cov->title }}
                            </a>
                        </h2>
                        @if($cov->subtitle)
                            <h3 class="text-sm font-semibold text-slate-700 mt-1">
                                {{ $cov->subtitle }}
                            </h3>
                        @endif
                        @if($cov->description)
                            <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                                {{ $cov->description }}
                            </p>
                        @endif
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Dimulai sejak {{ $cov->created_at->locale('id')->isoFormat('MMMM Y') }}</span>
                        <a href="{{ route('multimedia.special-coverage.show', $cov->slug) }}" class="inline-flex items-center text-xs font-bold bg-blue-950 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition">
                            <span>Buka Liputan Khusus</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1.5"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500 italic">Belum ada liputan khusus yang aktif.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $coverages->links() }}
    </div>

</div>
@endsection
