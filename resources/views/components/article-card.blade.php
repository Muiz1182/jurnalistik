@props(['article', 'layout' => 'standard'])

@if($layout === 'horizontal')
    <!-- Jawa Pos Signature Horizontal Card (Thumbnail Left + Category Kicker + Serif Title + Time) -->
    <article class="flex flex-col sm:flex-row gap-3.5 sm:gap-4 group bg-white border border-slate-200/90 rounded-2xl overflow-hidden p-3.5 sm:p-4 hover:shadow-md hover:border-slate-300 transition duration-300">
        <!-- Thumbnail -->
        <a href="{{ route('articles.show', $article->slug) }}" class="sm:w-48 sm:h-32 shrink-0 overflow-hidden rounded-xl bg-slate-100 block aspect-video sm:aspect-auto shadow-2xs">
            <img src="{{ $article->featured_image_url }}" 
                 alt="{{ $article->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        </a>
        <!-- Details -->
        <div class="flex flex-col justify-between flex-grow min-w-0">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <a href="{{ route('articles.category', $article->category->slug) }}" 
                       class="text-3xs font-black uppercase tracking-wider text-red-600 hover:text-[#0B2545] transition">
                        {{ $article->category->name }}
                    </a>
                    <span class="text-slate-300">&bull;</span>
                    <span class="text-3xs text-slate-500">
                        {{ $article->published_at ? $article->published_at->locale('id')->diffForHumans() : 'Baru' }}
                    </span>
                </div>
                <h3 class="font-serif font-bold text-slate-900 text-sm sm:text-base group-hover:text-red-600 transition leading-snug line-clamp-2">
                    <a href="{{ route('articles.show', $article->slug) }}">
                        {{ $article->title }}
                    </a>
                </h3>
                @if($article->excerpt)
                    <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed font-sans hidden sm:block">
                        {{ $article->excerpt }}
                    </p>
                @endif
            </div>
            <!-- Byline & Views -->
            <div class="flex items-center justify-between text-2xs text-slate-400 mt-2.5 pt-2 border-t border-slate-100">
                <span class="font-medium text-slate-700 flex items-center truncate mr-2">
                    <i data-lucide="user" class="w-3 h-3 mr-1 text-slate-400 shrink-0"></i>
                    <span class="truncate">{{ $article->author->name }}</span>
                </span>
                <span class="flex items-center font-semibold text-slate-500 shrink-0">
                    <i data-lucide="eye" class="w-3 h-3 mr-1 text-slate-400"></i>
                    {{ number_format($article->views_count) }}
                </span>
            </div>
        </div>
    </article>

@elseif($layout === 'compact')
    <!-- Compact Card (for Quick Sidebars & Mini Rubric Lists) -->
    <article class="flex gap-3 group items-start py-3 border-b border-slate-100 last:border-0">
        <a href="{{ route('articles.show', $article->slug) }}" class="w-20 h-16 shrink-0 overflow-hidden rounded-xl bg-slate-100 block shadow-2xs">
            <img src="{{ $article->featured_image_url }}" 
                 alt="{{ $article->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        </a>
        <div class="flex-grow min-w-0">
            <a href="{{ route('articles.category', $article->category->slug) }}" 
               class="text-3xs font-black text-red-600 hover:text-[#0B2545] uppercase tracking-wider block mb-0.5">
                {{ $article->category->name }}
            </a>
            <h4 class="font-serif font-bold text-xs text-slate-900 group-hover:text-red-600 transition leading-snug line-clamp-2">
                <a href="{{ route('articles.show', $article->slug) }}">
                    {{ $article->title }}
                </a>
            </h4>
            <span class="text-3xs text-slate-400 mt-1 block">
                {{ $article->published_at ? $article->published_at->locale('id')->diffForHumans() : '' }}
            </span>
        </div>
    </article>

@else
    <!-- Standard Editorial Grid Card -->
    <article class="flex flex-col bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs hover:shadow-md hover:border-slate-300 transition duration-300 group">
        <!-- Thumbnail Container -->
        <a href="{{ route('articles.show', $article->slug) }}" class="aspect-[16/10] overflow-hidden bg-slate-900 relative block">
            <img src="{{ $article->featured_image_url }}" 
                 alt="{{ $article->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            <span class="absolute top-3 left-3 bg-[#0B2545]/95 backdrop-blur-xs text-white text-3xs font-black uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs border border-white/10">
                {{ $article->category->name }}
            </span>
        </a>

        <!-- Content Area -->
        <div class="p-4 sm:p-5 flex flex-col justify-between flex-grow space-y-2.5">
            <div>
                <div class="flex items-center text-3xs text-slate-400 mb-2 space-x-2 font-medium">
                    <span>{{ $article->published_at ? $article->published_at->locale('id')->isoFormat('D MMMM Y') : 'Baru' }}</span>
                    <span>&bull;</span>
                    <span>~{{ $article->reading_time }} mnt baca</span>
                </div>

                <h3 class="font-serif font-bold text-slate-900 text-sm sm:text-base group-hover:text-red-600 transition leading-snug line-clamp-2">
                    <a href="{{ route('articles.show', $article->slug) }}">
                        {{ $article->title }}
                    </a>
                </h3>

                @if($article->excerpt)
                    <p class="text-xs text-slate-600 mt-1.5 line-clamp-2 leading-relaxed font-sans">
                        {{ $article->excerpt }}
                    </p>
                @endif
            </div>

            <!-- Footer Byline -->
            <div class="flex items-center justify-between text-2xs text-slate-500 pt-3 border-t border-slate-100">
                <span class="font-semibold text-slate-700 flex items-center truncate mr-2">
                    <i data-lucide="pen-tool" class="w-3 h-3 mr-1 text-slate-400 shrink-0"></i>
                    <span class="truncate">{{ $article->author->name }}</span>
                </span>
                <span class="flex items-center shrink-0 font-semibold text-slate-500">
                    <i data-lucide="eye" class="w-3 h-3 mr-1 text-slate-400"></i>
                    {{ number_format($article->views_count) }}
                </span>
            </div>
        </div>
    </article>
@endif
