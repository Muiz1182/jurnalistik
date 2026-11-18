@props(['article', 'layout' => 'standard'])

@if($layout === 'horizontal')
    <!-- Horizontal Card (e.g. for Category Sections or Search Results) -->
    <article class="flex flex-col sm:flex-row gap-4 group bg-white border border-slate-200/80 rounded-xl overflow-hidden p-3.5 hover:shadow-md transition">
        <!-- Thumbnail -->
        <a href="{{ route('articles.show', $article->slug) }}" class="sm:w-48 sm:h-32 shrink-0 overflow-hidden rounded-lg bg-slate-100 block aspect-video sm:aspect-auto">
            <img src="{{ $article->featured_image_url }}" 
                 alt="{{ $article->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        </a>
        <!-- Details -->
        <div class="flex flex-col justify-between flex-grow">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <a href="{{ route('articles.category', $article->category->slug) }}" 
                       class="text-xs font-bold uppercase tracking-wider text-blue-900 hover:text-red-600 transition">
                        {{ $article->category->name }}
                    </a>
                    <span class="text-slate-300">&bull;</span>
                    <span class="text-xs text-slate-500">
                        {{ $article->published_at ? $article->published_at->locale('id')->diffForHumans() : 'Baru' }}
                    </span>
                </div>
                <h3 class="font-bold text-slate-900 text-base group-hover:text-blue-900 transition leading-snug line-clamp-2">
                    <a href="{{ route('articles.show', $article->slug) }}">
                        {{ $article->title }}
                    </a>
                </h3>
                @if($article->excerpt)
                    <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">
                        {{ $article->excerpt }}
                    </p>
                @endif
            </div>
            <!-- Byline & Views -->
            <div class="flex items-center justify-between text-xs text-slate-400 mt-3 pt-2 border-t border-slate-100">
                <span class="font-medium text-slate-600 flex items-center">
                    <i data-lucide="user" class="w-3 h-3 mr-1 text-slate-400"></i>
                    {{ $article->author->name }}
                </span>
                <span class="flex items-center">
                    <i data-lucide="eye" class="w-3 h-3 mr-1 text-slate-400"></i>
                    {{ number_format($article->views_count) }}
                </span>
            </div>
        </div>
    </article>

@elseif($layout === 'compact')
    <!-- Compact Card (e.g. for Sidebar or Minor Grids) -->
    <article class="flex gap-3 group items-start py-2.5 border-b border-slate-100 last:border-0">
        <a href="{{ route('articles.show', $article->slug) }}" class="w-20 h-16 shrink-0 overflow-hidden rounded-md bg-slate-100 block">
            <img src="{{ $article->featured_image_url }}" 
                 alt="{{ $article->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
        </a>
        <div class="flex-grow">
            <a href="{{ route('articles.category', $article->category->slug) }}" 
               class="text-xs font-semibold text-blue-800 hover:underline block leading-tight">
                {{ $article->category->name }}
            </a>
            <h4 class="font-bold text-xs text-slate-900 group-hover:text-blue-900 transition leading-tight mt-1 line-clamp-2">
                <a href="{{ route('articles.show', $article->slug) }}">
                    {{ $article->title }}
                </a>
            </h4>
            <span class="text-xs text-slate-400 mt-1 block">
                {{ $article->published_at ? $article->published_at->locale('id')->isoFormat('D MMM Y') : '' }}
            </span>
        </div>
    </article>

@else
    <!-- Standard Grid Card -->
    <article class="flex flex-col bg-white border border-slate-200/90 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition group">
        <!-- Thumbnail Container -->
        <a href="{{ route('articles.show', $article->slug) }}" class="aspect-[16/10] overflow-hidden bg-slate-100 relative block">
            <img src="{{ $article->featured_image_url }}" 
                 alt="{{ $article->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            <span class="absolute top-3 left-3 bg-blue-950/90 text-white text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded shadow-sm">
                {{ $article->category->name }}
            </span>
        </a>

        <!-- Content Area -->
        <div class="p-4 flex flex-col justify-between flex-grow">
            <div>
                <div class="flex items-center text-xs text-slate-400 mb-2 space-x-2">
                    <span>{{ $article->published_at ? $article->published_at->locale('id')->isoFormat('D MMMM Y') : 'Baru' }}</span>
                    <span>&bull;</span>
                    <span>{{ $article->reading_time }} mnt baca</span>
                </div>

                <h3 class="font-bold text-slate-900 text-base group-hover:text-blue-900 transition leading-snug line-clamp-2">
                    <a href="{{ route('articles.show', $article->slug) }}">
                        {{ $article->title }}
                    </a>
                </h3>

                @if($article->excerpt)
                    <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                        {{ $article->excerpt }}
                    </p>
                @endif
            </div>

            <!-- Footer: Author & Views -->
            <div class="flex items-center justify-between text-xs text-slate-400 mt-4 pt-3 border-t border-slate-100">
                <span class="font-medium text-slate-700 flex items-center">
                    <i data-lucide="user" class="w-3 h-3 mr-1 text-slate-400"></i>
                    {{ $article->author->name }}
                </span>
                <span class="flex items-center text-slate-500 font-medium">
                    <i data-lucide="eye" class="w-3 h-3 mr-1 text-slate-400"></i>
                    {{ number_format($article->views_count) }}
                </span>
            </div>
        </div>
    </article>
@endif
