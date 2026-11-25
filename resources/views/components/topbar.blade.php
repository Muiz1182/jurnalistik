<div class="bg-[#0A192F] text-slate-300 text-xs border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1.5 flex items-center justify-between gap-4">
        <!-- Date, Edition & Trending Tagline -->
        <div class="flex items-center space-x-3 text-2xs sm:text-xs overflow-hidden">
            <span class="inline-flex items-center text-slate-100 font-semibold tracking-wide shrink-0">
                <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-blue-400 shrink-0"></i>
                <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            </span>
            <span class="text-slate-600 hidden sm:inline">&bull;</span>
            <span class="hidden sm:inline-flex items-center text-slate-300 shrink-0 font-medium">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1 text-red-400 shrink-0"></i>
                <span>Kota Probolinggo</span>
            </span>
            <span class="text-slate-600 hidden lg:inline">&bull;</span>
            <!-- Trending Topics Strip (Jawa Pos Editorial Touch) -->
            <div class="hidden lg:flex items-center space-x-2 text-2xs font-semibold text-slate-300 overflow-hidden truncate">
                <span class="text-amber-400 font-extrabold uppercase tracking-wider text-3xs shrink-0">Topik Populer:</span>
                @php
                    $trendingTags = \App\Models\Tag::has('articles')->withCount('articles')->orderByDesc('articles_count')->take(4)->get();
                @endphp
                @forelse($trendingTags as $tag)
                    <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}" class="hover:text-white transition">#{{ $tag->name }}</a>
                    @if(!$loop->last)<span class="text-slate-600">&bull;</span>@endif
                @empty
                    <a href="{{ route('articles.index', ['tag' => 'prestasi']) }}" class="hover:text-white transition">#PrestasiMurid</a>
                    <span class="text-slate-600">&bull;</span>
                    <a href="{{ route('articles.index', ['tag' => 'adiwiyata']) }}" class="hover:text-white transition">#AdiwiyataMandiri</a>
                    <span class="text-slate-600">&bull;</span>
                    <a href="{{ route('articles.index', ['tag' => 'literasi']) }}" class="hover:text-white transition">#PojokLiterasi</a>
                @endforelse
            </div>
        </div>

        <!-- Social Media & Auth Meja Redaksi -->
        <div class="flex items-center space-x-4 text-2xs sm:text-xs shrink-0">
            <div class="hidden sm:flex items-center space-x-3 text-slate-400 border-r border-slate-800 pr-4">
                <span class="text-3xs uppercase tracking-wider text-slate-400 font-bold">Kanal Resmi:</span>
                <!-- TikTok -->
                <a href="{{ \App\Models\Setting::get('social_tiktok', \App\Models\Setting::get('social_facebook', '#')) }}" target="_blank" rel="noopener" class="hover:text-cyan-300 transition" title="TikTok Resmi SPELAND">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.27 6.27 0 0 0 1.9-4.49V8.75a8.16 8.16 0 0 0 4.87 1.58V6.89c-.338-.002-.676-.07-1-.2z"/>
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" rel="noopener" class="hover:text-pink-400 transition" title="Instagram Resmi">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                    </svg>
                </a>
                <!-- YouTube -->
                <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" target="_blank" rel="noopener" class="hover:text-red-400 transition" title="YouTube SMPN 9">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            </div>

            <!-- Auth Meja Redaksi -->
            @auth
                <div class="flex items-center space-x-3">
                    @if(auth()->user()->canAccessDashboard())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center font-bold text-amber-300 hover:text-amber-200 transition bg-amber-950/80 border border-amber-800/80 px-2.5 py-1 rounded-lg text-2xs shadow-xs">
                            <i data-lucide="layout-dashboard" class="w-3 h-3 mr-1.5"></i>
                            Meja Redaksi
                        </a>
                    @else
                        <a href="{{ route('articles.bookmarks') }}" class="inline-flex items-center text-slate-300 hover:text-white transition">
                            <i data-lucide="bookmark" class="w-3 h-3 mr-1 text-blue-400"></i>
                            Bacaan Saya
                        </a>
                    @endif
                    <span class="text-slate-300 font-semibold hidden md:inline">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 transition text-2xs font-semibold">Keluar</button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="font-semibold text-slate-300 hover:text-white transition px-2 py-0.5 rounded hover:bg-slate-800">Masuk</a>
                    <span class="text-slate-700">/</span>
                    <a href="{{ route('register') }}" class="font-bold text-blue-400 hover:text-blue-300 transition px-2 py-0.5 rounded hover:bg-slate-800">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</div>
