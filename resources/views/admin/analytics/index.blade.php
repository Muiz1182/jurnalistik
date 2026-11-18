@extends('layouts.admin')

@section('title', 'Statistik & Analisis Redaksi - Meja Redaksi')
@section('page_title', 'Statistik & Analisis Pembaca')

@section('content')
<div class="space-y-6">

    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-500 block">Total Pembaca Artikel</span>
                <span class="text-2xl font-black text-slate-900 mt-1 block font-serif">{{ number_format($totalViews) }}</span>
                <span class="text-2xs text-emerald-600 font-bold mt-1 inline-flex items-center">
                    <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> Terakumulasi dari pembaca unik
                </span>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center">
                <i data-lucide="eye" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-500 block">Artikel Telah Terbit</span>
                <span class="text-2xl font-black text-blue-950 mt-1 block font-serif">{{ number_format($publishedCount) }}</span>
                <span class="text-2xs text-slate-400 mt-1 inline-flex items-center">
                    Dari total {{ $totalArticles }} draf & arsip
                </span>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-800 rounded-xl flex items-center justify-center">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-500 block">Produktivitas Tim Redaksi</span>
                <span class="text-2xl font-black text-slate-900 mt-1 block font-serif">{{ count($reporterStats) }}</span>
                <span class="text-2xs text-slate-400 mt-1 inline-flex items-center">
                    Jurnalis & staf aktif
                </span>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-800 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Trend 14 Hari & Kategori -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daily Views Trend Chart -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Tren Kunjungan Harian (14 Hari Terakhir)</h3>
                    <p class="text-2xs text-slate-400">Pola pembaca portal berita Jurnalistik SPELAND</p>
                </div>
                <span class="text-2xs font-mono font-bold bg-blue-50 text-blue-900 px-2.5 py-1 rounded">PostgreSQL Views Log</span>
            </div>

            <div class="h-64 relative">
                <canvas id="dailyViewsChart"></canvas>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
            <div class="pb-3 border-b border-slate-100">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Distribusi Rubrik / Kategori</h3>
                <p class="text-2xs text-slate-400">Jumlah artikel terbit per kategori</p>
            </div>

            <div class="space-y-3">
                @php $maxCat = $categoryStats->max('articles_count') ?: 1; @endphp
                @foreach($categoryStats->take(7) as $cat)
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span>{{ $cat->name }}</span>
                            <span class="font-mono text-slate-500">{{ $cat->articles_count }} berita</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-950 h-2 rounded-full transition-all" style="width: {{ ($cat->articles_count / $maxCat) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Articles & Reporter Ranking -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top 10 Read Articles -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Top 10 Artikel Terpopuler</h3>
                <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($topArticles as $idx => $art)
                    <div class="p-3.5 hover:bg-slate-50 flex items-start space-x-3 transition">
                        <span class="font-black text-sm font-serif w-6 text-slate-300">{{ $idx + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <span class="text-2xs font-bold uppercase text-blue-900 block">{{ $art->category->name ?? 'Berita' }}</span>
                            <a href="{{ route('articles.show', $art->slug) }}" target="_blank" class="text-xs font-bold text-slate-900 hover:text-blue-950 line-clamp-1">
                                {{ $art->title }}
                            </a>
                            <span class="text-2xs text-slate-400 block mt-0.5">Oleh {{ $art->author->name ?? 'Redaksi' }} &bull; {{ $art->published_at?->translatedFormat('d M Y') }}</span>
                        </div>
                        <span class="font-mono text-xs font-black text-slate-800 bg-slate-100 px-2 py-0.5 rounded shrink-0">
                            {{ number_format($art->views_count) }} views
                        </span>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Belum ada data artikel.</div>
                @endforelse
            </div>
        </div>

        <!-- Reporter Productivity -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Peringkat Produktivitas Redaksi</h3>
                <i data-lucide="feather" class="w-4 h-4 text-blue-900"></i>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($reporterStats as $idx => $rep)
                    <div class="p-3.5 hover:bg-slate-50 flex items-center justify-between transition">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $rep->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">{{ $rep->name }}</span>
                                <span class="text-2xs text-slate-400">{{ $rep->role->name ?? 'Reporter' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 text-right">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 block font-mono">{{ $rep->published_count }}</span>
                                <span class="text-2xs text-slate-400 block uppercase">Terbit</span>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-600 block font-mono">{{ $rep->draft_count }}</span>
                                <span class="text-2xs text-slate-400 block uppercase">Draf</span>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-blue-950 block font-mono">{{ $rep->articles_count }}</span>
                                <span class="text-2xs text-slate-400 block uppercase">Total</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Belum ada jurnalis terdaftar.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('dailyViewsChart');
        if (!ctx) return;

        const rawData = @json($dailyViews);
        const labels = rawData.length ? rawData.map(d => d.viewed_date) : ['Hari Ini'];
        const values = rawData.length ? rawData.map(d => parseInt(d.total_views)) : [0];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pembaca',
                    data: values,
                    borderColor: '#0A2540',
                    backgroundColor: 'rgba(10, 37, 64, 0.08)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#0A2540'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
