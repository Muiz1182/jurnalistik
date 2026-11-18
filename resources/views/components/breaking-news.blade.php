@php
    $breakingItem = \App\Models\Article::breaking()->first();
    $customBreakingActive = \App\Models\Setting::get('breaking_news_active', '0') === '1';
    $customText = \App\Models\Setting::get('breaking_news_text');
    $customUrl = \App\Models\Setting::get('breaking_news_url', '#');
@endphp

@if($breakingItem || ($customBreakingActive && $customText))
    <div class="bg-red-700 text-white text-xs border-b border-red-800 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center py-2">
            <!-- Label Badge -->
            <div class="flex items-center space-x-1.5 shrink-0 bg-red-900 text-white font-extrabold uppercase px-2.5 py-1 rounded tracking-wider shadow-sm mr-3">
                <span class="inline-block w-2 h-2 rounded-full bg-white animate-pulse"></span>
                <span>BREAKING NEWS</span>
            </div>

            <!-- Ticker Content -->
            <div class="overflow-hidden flex-grow whitespace-nowrap">
                @if($breakingItem)
                    <a href="{{ route('articles.show', $breakingItem->slug) }}" class="hover:underline font-semibold text-white tracking-wide">
                        {{ $breakingItem->title }}
                    </a>
                @elseif($customBreakingActive && $customText)
                    <a href="{{ $customUrl }}" class="hover:underline font-semibold text-white tracking-wide">
                        {{ $customText }}
                    </a>
                @endif
            </div>

            <!-- Detail CTA -->
            <div class="hidden sm:block shrink-0 ml-4">
                <a href="{{ $breakingItem ? route('articles.show', $breakingItem->slug) : $customUrl }}" class="text-red-200 hover:text-white font-bold inline-flex items-center">
                    <span>Baca</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-0.5"></i>
                </a>
            </div>
        </div>
    </div>
@endif
