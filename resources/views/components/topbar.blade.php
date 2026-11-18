<div class="bg-slate-950 text-slate-300 text-xs border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between gap-4">
        <!-- Date & Location -->
        <div class="flex items-center space-x-3 text-2xs sm:text-xs">
            <span class="inline-flex items-center text-slate-300 font-medium">
                <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-blue-400 shrink-0"></i>
                <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            </span>
            <span class="text-slate-700 hidden md:inline">&bull;</span>
            <span class="hidden md:inline-flex items-center text-slate-400">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1 text-slate-500 shrink-0"></i>
                <span>Kota Probolinggo, Jawa Timur</span>
            </span>
        </div>

        <!-- Social Media & Auth Meja Redaksi -->
        <div class="flex items-center space-x-4 text-2xs sm:text-xs">
            <div class="hidden sm:flex items-center space-x-3 text-slate-400 border-r border-slate-800 pr-4">
                <span class="text-2xs uppercase tracking-wider text-slate-500 font-semibold">Kanal Media:</span>
                <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" rel="noopener" class="hover:text-pink-400 transition" title="Instagram Resmi">
                    <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" target="_blank" rel="noopener" class="hover:text-red-400 transition" title="YouTube SMPN 9">
                    <i data-lucide="youtube" class="w-3.5 h-3.5"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" rel="noopener" class="hover:text-blue-400 transition" title="Facebook">
                    <i data-lucide="facebook" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <!-- Auth Meja Redaksi -->
            @auth
                <div class="flex items-center space-x-3">
                    @if(auth()->user()->canAccessDashboard())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center font-bold text-amber-300 hover:text-amber-200 transition bg-amber-950/60 border border-amber-800/80 px-2.5 py-0.5 rounded-full text-2xs">
                            <i data-lucide="layout-dashboard" class="w-3 h-3 mr-1"></i>
                            Meja Redaksi
                        </a>
                    @else
                        <a href="{{ route('articles.bookmarks') }}" class="inline-flex items-center text-slate-300 hover:text-white transition">
                            <i data-lucide="bookmark" class="w-3 h-3 mr-1 text-blue-400"></i>
                            Bacaan Saya
                        </a>
                    @endif
                    <span class="text-slate-400 font-medium hidden md:inline">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 transition text-2xs font-semibold">Keluar</button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="font-semibold text-slate-300 hover:text-white transition px-2 py-0.5 rounded hover:bg-slate-800">Masuk</a>
                    <span class="text-slate-700">/</span>
                    <a href="{{ route('register') }}" class="font-bold text-blue-400 hover:text-blue-300 transition px-2 py-0.5 rounded hover:bg-slate-800">Daftar Akun</a>
                </div>
            @endauth
        </div>
    </div>
</div>
