@php
    $breakingItems = \App\Models\Article::breaking()->with(['category'])->take(5)->get();
    $customBreakingActive = \App\Models\Setting::get('breaking_news_active', '0') === '1';
    $customText = \App\Models\Setting::get('breaking_news_text');
    $customUrl = \App\Models\Setting::get('breaking_news_url', '#');
    $hasBreaking = $breakingItems->isNotEmpty() || ($customBreakingActive && !empty(trim($customText)));
@endphp

@if($hasBreaking)
    <div class="bg-gradient-to-r from-red-50 via-white to-red-50/50 border-b border-red-200/70 py-2 sm:py-2.5"
         x-data="{
             activeIdx: 0,
             total: {{ $breakingItems->count() ?: 1 }},
             paused: false,
             timer: null,
             init() {
                 if (this.total > 1) {
                     this.timer = setInterval(() => {
                         if (!this.paused) {
                             this.activeIdx = (this.activeIdx + 1) % this.total;
                         }
                     }, 5000);
                 }
             }
         }"
         @mouseenter="paused = true"
         @mouseleave="paused = false">
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
                    <div class="truncate text-xs font-bold text-slate-900 flex-1 min-w-0">
                        @if($breakingItems->isNotEmpty())
                            @foreach($breakingItems as $idx => $bItem)
                                <div x-show="activeIdx === {{ $idx }}" 
                                     x-cloak
                                     class="truncate"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0">
                                    <a href="{{ route('articles.show', $bItem->slug) }}" class="hover:text-red-600 transition inline-flex items-center max-w-full truncate">
                                        <span class="text-3xs uppercase font-black text-red-600 mr-2 shrink-0 hidden sm:inline">[{{ $bItem->category->name }}]</span>
                                        <span class="truncate">{{ $bItem->title }}</span>
                                    </a>
                                </div>
                            @endforeach
                        @elseif($customBreakingActive && $customText)
                            <a href="{{ $customUrl }}" class="hover:text-red-600 transition inline-flex items-center max-w-full truncate">
                                <span class="truncate">{{ $customText }}</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Right Action Link & Indicator -->
                <div class="shrink-0 pl-2 flex items-center space-x-2">
                    @if($breakingItems->count() > 1)
                        <span class="text-3xs text-slate-400 font-mono hidden sm:inline" x-text="(activeIdx + 1) + '/' + total"></span>
                    @endif
                    <a href="{{ $breakingItems->isNotEmpty() ? route('articles.show', $breakingItems->first()->slug) : $customUrl }}" 
                       class="text-xs font-bold text-red-600 hover:text-red-700 transition inline-flex items-center space-x-1 group">
                        <span class="hidden sm:inline">Baca Liputan</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endif
