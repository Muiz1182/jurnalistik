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
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js & Lucide Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #0F172A;
            background-color: #FFFFFF;
        }
        .font-editorial {
            font-family: 'Merriweather', Georgia, serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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
<body class="min-h-screen flex flex-col bg-white text-slate-900 antialiased selection:bg-blue-900 selection:text-white" x-data="{ mobileMenuOpen: false, searchOpen: false }">

    <!-- TOP BAR -->
    @include('components.topbar')

    <!-- MAIN HEADER -->
    @include('components.header')

    <!-- NAVIGATION MENU -->
    @include('components.navbar')

    <!-- BREAKING NEWS TICKER -->
    @include('components.breaking-news')

    <!-- TOAST NOTIFICATIONS -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 flex items-center bg-emerald-800 text-white px-5 py-3.5 rounded-lg shadow-xl text-sm font-medium border border-emerald-700 animate-slide-up">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 shrink-0 text-emerald-300"></i>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-emerald-200 hover:text-white focus:outline-none">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="fixed bottom-6 right-6 z-50 flex items-center bg-red-800 text-white px-5 py-3.5 rounded-lg shadow-xl text-sm font-medium border border-red-700 animate-slide-up">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-3 shrink-0 text-red-300"></i>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="ml-4 text-red-200 hover:text-white focus:outline-none">
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

    <!-- QUICK SEARCH MODAL -->
    <div x-show="searchOpen" 
         x-cloak
         @keydown.escape.window="searchOpen = false"
         class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="searchOpen = false" class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden animate-scale-up">
            <form action="{{ route('articles.search') }}" method="GET" class="flex items-center border-b border-slate-200 px-4 py-3.5">
                <i data-lucide="search" class="w-5 h-5 text-slate-400 mr-3"></i>
                <input type="text" 
                       name="q" 
                       placeholder="Cari berita, prestasi, pengumuman sekolah..." 
                       class="w-full text-slate-800 placeholder-slate-400 focus:outline-none text-base"
                       autofocus>
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold px-4 py-2 rounded-md ml-3 transition">
                    Cari
                </button>
            </form>
            <div class="p-4 bg-slate-50 text-xs text-slate-500 flex justify-between items-center">
                <span>Pencarian berbasis PostgreSQL Full Text Search</span>
                <span class="text-slate-400">Tekan ESC untuk menutup</span>
            </div>
        </div>
    </div>

    <!-- INITIALIZE LUCIDE ICONS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        window.addEventListener('alpine:initialized', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
