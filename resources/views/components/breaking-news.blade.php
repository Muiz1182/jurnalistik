@php
    $breakingItem = \App\Models\Article::breaking()->first();
    $customBreakingActive = \App\Models\Setting::get('breaking_news_active', '0') === '1';
    $customText = \App\Models\Setting::get('breaking_news_text');
    $customUrl = \App\Models\Setting::get('breaking_news_url', '#');
@endphp

@if($breakingItem || ($customBreakingActive && $customText))
    <div class="bg-gradient-to-r from-red-50 via-white to-red-50/50 border-b border-red-200/70 py-2.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-3">
                
                <!-- Label & Ticker Content -->
                <div class="flex items-center space-x-3 min-w-0 flex-1">
                    <!-- Badge -->
                    <div class="flex items-center space-x-1.5 shrink-0 bg-red-600 text-white font-black uppercase text-3xs sm:text-2xs px-2.5 py-1 rounded-md tracking-wider shadow-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                        <span>BREAKING NEWS</span>
                    </div>

                    <!-- Headline text -->
                    <div class="truncate text-xs font-bold text-slate-900">
                        @if($breakingItem)
                            <a href="{{ route('articles.show', $breakingItem->slug) }}" class="hover:text-red-600 transition inline-flex items-center">
                                <span>{{ $breakingItem->title }}</span>
                            </a>
                        @elseif($customBreakingActive && $customText)
                            <a href="{{ $customUrl }}" class="hover:text-red-600 transition inline-flex items-center">
                                <span>{{ $customText }}</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Right Action Link -->
                <div class="shrink-0 pl-2">
                    <a href="{{ $breakingItem ? route('articles.show', $breakingItem->slug) : $customUrl }}" 
                       class="text-xs font-bold text-red-600 hover:text-red-700 transition inline-flex items-center space-x-1 group">
                        <span class="hidden sm:inline">Baca Liputan</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endif
