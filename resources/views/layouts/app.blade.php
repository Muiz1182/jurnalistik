<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'JURNALISTIK SPELAND | Mengabarkan Fakta, Menyuarakan Cerita')</title>
    <meta name="description" content="@yield('meta_description', 'Portal berita dan publikasi digital resmi SMP Negeri 9 Probolinggo. Wadah kreativitas jurnalistik, literasi, dan prestasi murid.')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'JURNALISTIK SPELAND | Mengabarkan Fakta, Menyuarakan Cerita')">
    <meta property="og:description" content="@yield('meta_description', 'Portal berita dan publikasi digital resmi SMP Negeri 9 Probolinggo.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'JURNALISTIK SPELAND')">
    <meta name="twitter:description" content="@yield('meta_description', 'Portal berita digital SMP Negeri 9 Probolinggo.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Google Fonts: Plus Jakarta Sans & Merriweather -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Alpine.js & Lucide Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #0F172A;
            background-color: #FAFAFA;
        }
        .font-editorial {
            font-family: 'Merriweather', Georgia, serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        ::-webkit-scrollbar-thumb {
            background: #94A3B8;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #64748B;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-[#FDFDFD] text-slate-900 antialiased selection:bg-blue-900 selection:text-white"
      x-data="{ mobileMenuOpen: false, searchOpen: false }"
      @keydown.window.ctrl.k.prevent="searchOpen = true"
      @keydown.window.meta.k.prevent="searchOpen = true"
      @keydown.escape.window="searchOpen = false; mobileMenuOpen = false">

    <!-- TOP BAR -->
    @include('components.topbar')

    <!-- MAIN HEADER (EDITORIAL MASTHEAD) -->
    @include('components.header')

    <!-- NAVIGATION MENU -->
    @include('components.navbar')

    <!-- BREAKING NEWS TICKER -->
    @include('components.breaking-news')

    <!-- TOAST NOTIFICATIONS -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 flex items-center bg-slate-900 text-white px-5 py-3.5 rounded-xl shadow-2xl text-xs font-semibold border border-slate-700 animate-slide-up">
            <span class="w-2 h-2 rounded-full bg-emerald-400 mr-3 animate-ping"></span>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-slate-400 hover:text-white focus:outline-none">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="fixed bottom-6 right-6 z-50 flex items-center bg-red-950 text-white px-5 py-3.5 rounded-xl shadow-2xl text-xs font-semibold border border-red-800 animate-slide-up">
            <span class="w-2 h-2 rounded-full bg-red-400 mr-3 animate-ping"></span>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="ml-4 text-red-300 hover:text-white focus:outline-none">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('components.footer')

    <!-- MODERN FULL-SCREEN SEARCH MODAL -->
    <div x-show="searchOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-sm flex items-start justify-center pt-20 px-4 pb-6"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="searchOpen = false" 
             class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200"
             x-transition:enter="transition ease-out duration-200 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">Pencarian Arsip Berita SPELAND</h3>
                        <p class="text-2xs text-slate-400">Didukung mesin pencari PostgreSQL Full-Text Search</p>
                    </div>
                </div>
                <button @click="searchOpen = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('articles.search') }}" method="GET" class="mt-4">
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           autofocus
                           required
                           class="w-full pl-11 pr-24 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:bg-white transition"
                           placeholder="Ketik topik berita, nama tokoh, adiwiyata, prestasi...">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </div>
                    <button type="submit" class="absolute inset-y-1.5 right-1.5 px-4 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-bold transition shadow-xs">
                        Cari
                    </button>
                </div>
            </form>

            <div class="mt-5 pt-4 border-t border-slate-100">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Pencarian Populer:</span>
                <div class="flex flex-wrap gap-1.5">
                    <a href="{{ route('articles.search', ['q' => 'adiwiyata']) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-900 rounded-md text-2xs font-semibold text-slate-600 transition">#AdiwiyataMandiri</a>
                    <a href="{{ route('articles.search', ['q' => 'prestasi']) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-900 rounded-md text-2xs font-semibold text-slate-600 transition">#PrestasiMurid</a>
                    <a href="{{ route('articles.search', ['q' => 'pramuka']) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-900 rounded-md text-2xs font-semibold text-slate-600 transition">#PramukaSPELAND</a>
                    <a href="{{ route('articles.search', ['q' => 'p5']) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-900 rounded-md text-2xs font-semibold text-slate-600 transition">#KearifanLokalP5</a>
                    <a href="{{ route('articles.search', ['q' => 'literasi']) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-900 rounded-md text-2xs font-semibold text-slate-600 transition">#PojokLiterasi</a>
                </div>
            </div>
        </div>
    </div>

    <!-- INITIALIZE LUCIDE ICONS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
