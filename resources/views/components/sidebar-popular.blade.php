@props(['popularArticles'])

<div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
    <div class="flex items-center justify-between border-b-2 border-blue-950 pb-3 mb-4">
        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wider flex items-center">
            <span class="w-2.5 h-2.5 bg-red-600 rounded-full mr-2"></span>
            Terpopuler
        </h3>
        <a href="{{ route('articles.popular') }}" class="text-xs font-semibold text-blue-900 hover:underline">
            Lihat Semua
        </a>
    </div>

    <div class="space-y-4">
        @forelse($popularArticles as $index => $popular)
            <div class="flex items-start space-x-3 group">
                <!-- Rank Number -->
                <span class="text-2xl font-black text-slate-300 group-hover:text-blue-900 transition leading-none shrink-0 w-6 text-center">
                    {{ $index + 1 }}
                </span>
                <div class="flex-grow">
                    <a href="{{ route('articles.category', $popular->category->slug) }}" 
                       class="text-xs font-semibold text-blue-900 hover:underline uppercase tracking-wider block mb-1">
                        {{ $popular->category->name }}
                    </a>
                    <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-blue-900 transition leading-snug line-clamp-2">
                        <a href="{{ route('articles.show', $popular->slug) }}">
                            {{ $popular->title }}
                        </a>
                    </h4>
                    <div class="flex items-center text-xs text-slate-400 mt-1 space-x-2">
                        <span>{{ number_format($popular->views_count) }} dibaca</span>
                        <span>&bull;</span>
                        <span>{{ $popular->published_at ? $popular->published_at->locale('id')->diffForHumans() : '' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-500 italic py-2">Belum ada statistik berita terpopuler.</p>
        @endforelse
    </div>
</div>
