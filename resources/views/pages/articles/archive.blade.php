@extends('layouts.app')

@section('title', 'Arsip Berita - JURNALISTIK SPELAND')
@section('meta_description', 'Arsip publikasi berita dan dokumentasi SMP Negeri 9 Probolinggo berdasarkan bulan dan tahun.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="border-b-2 border-blue-950 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-y-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
                <i data-lucide="archive" class="w-6 h-6 mr-2 text-blue-900"></i>
                Arsip Berita
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Jelajahi kembali rekam jejak berita dan kegiatan sekolah dari waktu ke waktu.
            </p>
        </div>

        <!-- Archive Month & Year Selector -->
        <form method="GET" action="{{ route('articles.archive') }}" class="flex items-center space-x-2">
            <select name="bulan" onchange="this.form.submit()" class="text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-700">
                @for($m = 1; $m <= 12; $m++)
                    @php $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                    <option value="{{ $monthNum }}" {{ $month == $monthNum ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(2026, $m, 1)->locale('id')->isoFormat('MMMM') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" onchange="this.form.submit()" class="text-xs font-semibold bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-700">
                @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- Archive Results Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <x-article-card :article="$article" />
        @empty
            <div class="col-span-3 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <i data-lucide="calendar-x" class="w-10 h-10 text-slate-400 mx-auto mb-2"></i>
                <h3 class="text-base font-bold text-slate-700">Tidak ada arsip berita pada periode ini</h3>
                <p class="text-xs text-slate-500 mt-1">Silakan pilih bulan atau tahun lain.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $articles->links() }}
    </div>

</div>
@endsection
