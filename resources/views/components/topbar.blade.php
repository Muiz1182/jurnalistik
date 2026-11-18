<div class="bg-slate-900 text-slate-300 text-xs border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-wrap items-center justify-between gap-y-2">
        <!-- Date & Location -->
        <div class="flex items-center space-x-4">
            <span class="flex items-center text-slate-300 font-medium">
                <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-blue-400"></i>
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </span>
            <span class="hidden md:inline-block text-slate-600">|</span>
            <span class="hidden md:flex items-center text-slate-400">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                SMP Negeri 9 Probolinggo
            </span>
        </div>

        <!-- Social Links & Editorial Access -->
        <div class="flex items-center space-x-4">
            <div class="hidden sm:flex items-center space-x-3 text-slate-400">
                <span class="text-slate-400 font-normal">Kanal Resmi:</span>
                <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" rel="noopener" class="hover:text-white transition" title="Instagram Resmi">
                    <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" target="_blank" rel="noopener" class="hover:text-white transition" title="YouTube SMPN 9">
                    <i data-lucide="youtube" class="w-3.5 h-3.5"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" rel="noopener" class="hover:text-white transition" title="Facebook">
                    <i data-lucide="facebook" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <span class="text-slate-600">|</span>

            <!-- User Auth Links -->
            @auth
                <div class="flex items-center space-x-3">
                    @if(auth()->user()->canAccessDashboard())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center font-semibold text-blue-400 hover:text-blue-300 transition">
                            <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 mr-1"></i>
                            Meja Redaksi
                        </a>
                    @else
                        <a href="{{ route('articles.bookmarks') }}" class="inline-flex items-center text-slate-300 hover:text-white transition">
                            <i data-lucide="bookmark" class="w-3.5 h-3.5 mr-1"></i>
                            Bacaan Saya
                        </a>
                    @endif
                    <span class="text-slate-500 font-medium">({{ auth()->user()->name }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 transition font-medium">Keluar</button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-2.5">
                    <a href="{{ route('login') }}" class="font-medium text-slate-300 hover:text-white transition">Masuk</a>
                    <span class="text-slate-600">/</span>
                    <a href="{{ route('register') }}" class="font-medium text-blue-400 hover:text-blue-300 transition">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</div>
