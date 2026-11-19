@extends('layouts.app')

@section('title', 'Arsip Berita - JURNALISTIK SPELAND')
@section('meta_description', 'Arsip publikasi berita dan dokumentasi SMP Negeri 9 Probolinggo berdasarkan bulan dan tahun.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <!-- Header Section -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Arsip Berita</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-1 border-t border-slate-100">
            <div>
                <span class="text-3xs uppercase tracking-widest font-black text-amber-600 font-mono block mb-1">DOKUMENTASI HISTORIS</span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                    Arsip Publikasi Berita
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                    Jelajahi kembali rekam jejak berita, pencapaian murid, dan liputan kegiatan sekolah dari waktu ke waktu.
                </p>
            </div>

            <!-- Archive Month & Year Selector -->
            <form method="GET" action="{{ route('articles.archive') }}" class="flex flex-wrap items-center gap-2">
                <select name="bulan" onchange="this.form.submit()" class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    @for($m = 1; $m <= 12; $m++)
                        @php $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                        <option value="{{ $monthNum }}" {{ $month == $monthNum ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(2026, $m, 1)->locale('id')->isoFormat('MMMM') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" onchange="this.form.submit()" class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    @for($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    <!-- Archive Results Grid with Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Main Content (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <div class="col-span-2 bg-white border border-slate-200/90 rounded-2xl p-8 sm:p-12 text-center shadow-2xs space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto shadow-2xs">
                            <i data-lucide="calendar-x" class="w-7 h-7"></i>
                        </div>
                        <div class="max-w-md mx-auto space-y-1.5">
                            <h2 class="text-base sm:text-lg font-serif font-bold text-slate-900">Tidak Ada Arsip pada Periode Ini</h2>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-sans">
                                Belum ada naskah terbit pada bulan dan tahun yang dipilih. Silakan pilih rentang waktu lainnya.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        <!-- Consistent Right Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>
    </div>

</div>
@endsection

        <!-- Consistent Right Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <x-sidebar-popular :popularArticles="$popularArticles" />
        </aside>
    </div>

</div>
@endsection
