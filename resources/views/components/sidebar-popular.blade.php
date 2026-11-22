@props(['popularArticles'])

<div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-2xs">
    <!-- Jawa Pos Style Broadside Ranking Header -->
    <div class="flex items-center justify-between pb-3.5 border-b-2 border-slate-900 mb-5">
        <h3 class="font-black text-slate-950 text-xs sm:text-sm uppercase tracking-wider flex items-center border-l-4 border-red-600 pl-2.5">
            Berita Terpopuler
        </h3>
        <a href="{{ route('articles.popular') }}" class="text-3xs font-bold uppercase tracking-wider text-red-600 hover:text-red-700 transition flex items-center group">
            <span>Lihat Semua</span>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-0.5 group-hover:translate-x-0.5 transition-transform"></i>
        </a>
    </div>

    <div class="space-y-4 divide-y divide-slate-100">
        @forelse($popularArticles as $index => $popular)
            <div class="flex items-start space-x-3.5 group pt-3.5 first:pt-0">
                <!-- Signature Jawa Pos Numbered Ranking -->
                @if($index === 0)
                    <div class="w-8 h-8 rounded-lg bg-red-600 text-white font-serif font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        01
                    </div>
                @elseif($index === 1)
                    <div class="w-8 h-8 rounded-lg bg-[#0B2545] text-white font-serif font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        02
                    </div>
                @elseif($index === 2)
                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-amber-400 font-serif font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        03
                    </div>
                @else
                    <span class="font-serif font-black text-2xl text-slate-300 group-hover:text-red-600 transition leading-none shrink-0 w-8 text-center select-none pt-1">
                        {{ sprintf('%02d', $index + 1) }}
                    </span>
                @endif

                <div class="flex-grow min-w-0">
                    <a href="{{ route('articles.category', $popular->category->slug) }}" 
                       class="text-3xs font-black text-red-600 hover:text-[#0B2545] uppercase tracking-wider block mb-1">
                        {{ $popular->category->name }}
                    </a>
                    <h4 class="font-serif font-bold text-xs sm:text-sm text-slate-900 group-hover:text-red-600 transition leading-snug line-clamp-2">
                        <a href="{{ route('articles.show', $popular->slug) }}">
                            {{ $popular->title }}
                        </a>
                    </h4>
                    <div class="flex items-center text-3xs text-slate-400 mt-1.5 space-x-2">
                        <span class="flex items-center text-amber-600 font-bold">
                            <i data-lucide="flame" class="w-3 h-3 mr-0.5 text-red-500"></i>
                            {{ number_format($popular->views_count) }} dibaca
                        </span>
                        <span>&bull;</span>
                        <span>{{ $popular->published_at ? $popular->published_at->locale('id')->diffForHumans() : '' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-6 text-center space-y-2">
                <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto">
                    <i data-lucide="trending-up" class="w-5 h-5 text-red-500"></i>
                </div>
                <p class="text-xs text-slate-800 font-bold">Peringkat Berita Populer</p>
                <p class="text-3xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                    Statistik artikel terpopuler akan diperbarui otomatis berdasarkan akumulasi kunjungan pembaca unik.
                </p>
            </div>
        @endforelse
    </div>
</div>
