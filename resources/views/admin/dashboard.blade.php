@extends('layouts.admin')

@section('title', 'Dashboard Redaksi - JURNALISTIK SPELAND')
@section('page_title', 'Ringkasan Meja Redaksi')

@section('content')
<div class="space-y-6">

    <!-- Editorial Role Specific Notice -->
    @if(auth()->user()->hasRole(['pemimpin-redaksi', 'super-admin']) && $stats['submitted_to_kadiv'] > 0)
        <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-xl shadow-xs flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-amber-950">
                        {{ $stats['submitted_to_kadiv'] }} Naskah Menunggu Persetujuan Kadiv
                    </h3>
                    <p class="text-xs text-amber-800">
                        Editor telah mengajukan naskah untuk dipantau, ditinjau, dan disetujui untuk terbit ke website.
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.articles.index', ['status' => 'submitted']) }}" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg transition shrink-0">
                Tinjau Antrean
            </a>
        </div>
    @elseif(auth()->user()->hasRole('editor') && $stats['my_revisions'] > 0)
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl shadow-xs flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-rose-950">
                        {{ $stats['my_revisions'] }} Naskah Memerlukan Revisi
                    </h3>
                    <p class="text-xs text-rose-800">
                        Kadiv mengembalikan naskah dengan catatan perbaikan sebelum dapat disetujui.
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.articles.index', ['status' => 'revision_required']) }}" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg transition shrink-0">
                Lihat Catatan Kadiv
            </a>
        </div>
    @endif

    <!-- 1. Real PostgreSQL Metrics Overview -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        @if(auth()->user()->hasRole('editor'))
            <!-- Editor View Cards -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Draf Naskah Saya</span>
                    <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                        <i data-lucide="file-edit" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['my_drafts']) }}</span>
                    <span class="text-xs text-slate-500 font-semibold">Sedang Ditulis</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Diajukan ke Kadiv</span>
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                        <i data-lucide="send" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['my_submitted']) }}</span>
                    <span class="text-xs text-amber-700 font-semibold">Menunggu Putusan</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Perlu Revisi</span>
                    <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-700 flex items-center justify-center">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['my_revisions']) }}</span>
                    <span class="text-xs text-rose-700 font-semibold">Catatan dari Kadiv</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Artikel Terbit</span>
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['my_published']) }}</span>
                    <span class="text-xs text-emerald-600 font-semibold">Tayang di Website</span>
                </div>
            </div>
        @else
            <!-- Kadiv & Super Admin View Cards -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu Kadiv</span>
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['submitted_to_kadiv']) }}</span>
                    <span class="text-xs text-amber-700 font-semibold">Diajukan Editor</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sedang Ditinjau</span>
                    <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['under_review_articles']) }}</span>
                    <span class="text-xs text-blue-800 font-semibold">Meja Kadiv</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Perlu Revisi</span>
                    <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-700 flex items-center justify-center">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['revision_required']) }}</span>
                    <span class="text-xs text-rose-700 font-semibold">Diperbaiki Editor</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Artikel Terbit</span>
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="globe" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($stats['published_articles']) }}</span>
                    <span class="text-xs text-emerald-600 font-semibold">Tayang Publik</span>
                </div>
            </div>
        @endif

    </div>

    <!-- 2. Workflow Queue & Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Antrean Persetujuan / Review Queue (7 Cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                <h2 class="font-bold text-sm text-slate-900 uppercase tracking-wider flex items-center">
                    <i data-lucide="git-pull-request" class="w-4 h-4 mr-2 text-blue-900"></i>
                    @if(auth()->user()->hasRole('editor'))
                        Naskah Saya Dalam Proses Redaksi
                    @else
                        Antrean Persetujuan Meja Kadiv
                    @endif
                </h2>
                <a href="{{ route('admin.articles.index', ['status' => auth()->user()->hasRole('editor') ? 'submitted' : 'submitted']) }}" class="text-xs font-bold text-blue-900 hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-3">
                @forelse($reviewQueue as $article)
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-lg flex items-start justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-2xs font-bold uppercase px-2 py-0.5 rounded {{ $article->status === 'submitted' ? 'bg-amber-100 text-amber-800' : ($article->status === 'revision_required' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800') }}">
                                    @if($article->status === 'submitted')
                                        Menunggu Putusan Kadiv
                                    @elseif($article->status === 'revision_required')
                                        Perlu Revisi Kadiv
                                    @elseif($article->status === 'under_review')
                                        Sedang Ditinjau Kadiv
                                    @else
                                        {{ str_replace('_', ' ', $article->status) }}
                                    @endif
                                </span>
                                <span class="text-xs text-slate-400">&bull;</span>
                                <span class="text-xs text-slate-500">{{ $article->category->name }}</span>
                            </div>
                            <h3 class="font-bold text-sm text-slate-900 line-clamp-1">
                                {{ $article->title }}
                            </h3>
                            <div class="text-xs text-slate-500 mt-1">
                                Penulis: <strong>{{ $article->author->name }}</strong> &bull; {{ $article->updated_at->locale('id')->diffForHumans() }}
                            </div>
                        </div>

                        <a href="{{ route('admin.articles.edit', $article) }}" class="shrink-0 bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition shadow-2xs">
                            @if(auth()->user()->hasRole('editor'))
                                Buka Naskah
                            @else
                                Tinjau & Putuskan
                            @endif
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 italic py-4 text-center">
                        Tidak ada naskah yang menunggu peninjauan saat ini.
                    </p>
                @endforelse
            </div>
        </div>

        <!-- Publication Chart / Quick Actions (5 Cols) -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <h2 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-3 mb-4 flex items-center">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-2 text-emerald-600"></i>
                    Aksi Cepat Redaksi
                </h2>
                
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <a href="{{ route('admin.articles.create') }}" class="p-3 bg-blue-950 text-white rounded-lg text-center hover:bg-blue-900 transition font-bold text-xs flex flex-col items-center justify-center">
                        <i data-lucide="plus-circle" class="w-5 h-5 mb-1 text-blue-300"></i>
                        <span>Tulis Berita Baru</span>
                    </a>
                    <a href="{{ route('admin.galleries.create') }}" class="p-3 bg-slate-800 text-white rounded-lg text-center hover:bg-slate-700 transition font-bold text-xs flex flex-col items-center justify-center">
                        <i data-lucide="camera" class="w-5 h-5 mb-1 text-slate-300"></i>
                        <span>Upload Galeri Foto</span>
                    </a>
                </div>

                <div class="space-y-2 text-xs text-slate-600">
                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                        <span>Total Reporter Terdaftar:</span>
                        <strong class="text-slate-900">{{ $stats['total_reporters'] }} orang</strong>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                        <span>Komentar Menunggu Moderasi:</span>
                        <strong class="{{ $stats['pending_comments'] > 0 ? 'text-red-600 font-bold' : 'text-slate-900' }}">
                            {{ $stats['pending_comments'] }} komentar
                        </strong>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 text-2xs text-slate-400 flex items-center justify-between">
                <span>Database: PostgreSQL 18 (jurnalistik_speland)</span>
                <span class="text-emerald-600 font-semibold flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1 inline-block"></span>
                    Sistem Aktif
                </span>
            </div>
        </div>

    </div>

    <!-- 3. Popular Articles Ranking & Recent Activity Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Popular Articles Table (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-xl p-5 shadow-2xs">
            <h2 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-3 mb-4 flex items-center">
                <i data-lucide="flame" class="w-4 h-4 mr-2 text-red-600"></i>
                Artikel Paling Banyak Dibaca
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase">
                            <th class="pb-2.5">Judul Artikel</th>
                            <th class="pb-2.5">Kategori</th>
                            <th class="pb-2.5 text-right">Pembaca</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($popularArticles as $pop)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 pr-3 font-semibold text-slate-900 line-clamp-1 max-w-xs">
                                    <a href="{{ route('articles.show', $pop->slug) }}" target="_blank" class="hover:text-blue-900">
                                        {{ $pop->title }}
                                    </a>
                                </td>
                                <td class="py-2.5 text-slate-500">{{ $pop->category->name }}</td>
                                <td class="py-2.5 text-right font-bold text-blue-900">{{ number_format($pop->views_count) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activity Log Stream (5 cols) -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-xl p-5 shadow-2xs">
            <h2 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-3 mb-4 flex items-center">
                <i data-lucide="activity" class="w-4 h-4 mr-2 text-blue-900"></i>
                Aktivitas Redaksi Terkini
            </h2>

            <div class="space-y-3">
                @forelse($recentActivities as $act)
                    <div class="text-xs pb-2 border-b border-slate-100 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between text-slate-400 mb-0.5">
                            <span class="font-semibold text-slate-700">{{ $act->user ? $act->user->name : 'Sistem' }}</span>
                            <span>{{ $act->created_at->locale('id')->diffForHumans() }}</span>
                        </div>
                        <p class="text-slate-800 leading-snug">
                            {{ $act->description }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic py-2">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
