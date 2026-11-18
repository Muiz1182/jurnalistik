@props(['popularArticles'])

<div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-2xs">
    <div class="flex items-center justify-between pb-3.5 border-b-2 border-slate-900 mb-5">
        <h3 class="font-black text-slate-950 text-xs uppercase tracking-wider flex items-center">
            <span class="w-2.5 h-2.5 bg-red-600 rounded-sm mr-2 animate-pulse"></span>
            Berita Terpopuler
        </h3>
        <a href="{{ route('articles.popular') }}" class="text-3xs font-bold uppercase tracking-wider text-blue-900 hover:text-red-600 transition">
            Lihat Semua &rarr;
        </a>
    </div>

    <div class="space-y-4 divide-y divide-slate-100">
        @forelse($popularArticles as $index => $popular)
            <div class="flex items-start space-x-3.5 group pt-3.5 first:pt-0">
                <!-- Rank Number (Bold Serif Newspaper Ranking) -->
                <span class="font-serif font-black text-2xl sm:text-3xl text-slate-300 group-hover:text-blue-950 transition leading-none shrink-0 w-7 text-center select-none">
                    {{ sprintf('%02d', $index + 1) }}
                </span>

                <div class="flex-grow min-w-0">
                    <a href="{{ route('articles.category', $popular->category->slug) }}" 
                       class="text-3xs font-extrabold text-blue-900 hover:text-red-600 uppercase tracking-wider block mb-1">
                        {{ $popular->category->name }}
                    </a>
                    <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-blue-950 transition leading-snug line-clamp-2">
                        <a href="{{ route('articles.show', $popular->slug) }}">
                            {{ $popular->title }}
                        </a>
                    </h4>
                    <div class="flex items-center text-3xs text-slate-400 mt-1.5 space-x-2">
                        <span class="flex items-center text-amber-600 font-semibold">
                            <i data-lucide="flame" class="w-3 h-3 mr-0.5 text-amber-500"></i>
                            {{ number_format($popular->views_count) }} dibaca
                        </span>
                        <span>&bull;</span>
                        <span>{{ $popular->published_at ? $popular->published_at->locale('id')->diffForHumans() : '' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-6 text-center space-y-2">
                <i data-lucide="trending-up" class="w-6 h-6 text-slate-300 mx-auto"></i>
                <p class="text-xs text-slate-500 font-medium">Belum ada statistik artikel terpopuler.</p>
                <p class="text-3xs text-slate-400">Peringkat akan diperbarui secara otomatis berdasarkan akumulasi pembaca unik.</p>
            </div>
        @endforelse
    </div>
</div>
