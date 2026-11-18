<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Meja Redaksi - JURNALISTIK SPELAND')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js & Lucide Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart.js for real PostgreSQL metrics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col justify-between border-r border-slate-800">
            
            <!-- Sidebar Header & Nav -->
            <div class="flex flex-col h-full overflow-y-auto">
                <!-- Brand Masthead -->
                <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-blue-600 text-white rounded-lg flex items-center justify-center font-black text-sm">
                            JS
                        </div>
                        <div>
                            <span class="font-extrabold text-sm text-white tracking-tight block">REDAKSI SPELAND</span>
                            <span class="text-xs text-slate-400 block">Sistem Redaksi Digital</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Navigation List -->
                <nav class="p-4 space-y-1 text-xs font-semibold flex-grow">
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-blue-300' : 'text-slate-400' }}"></i>
                        <span>Dashboard Utama</span>
                    </a>

                    <div class="pt-3 pb-1 px-3 text-slate-400 uppercase tracking-wider text-2xs font-bold">
                        Penerbitan Berita
                    </div>

                    <a href="{{ route('admin.articles.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.articles.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <div class="flex items-center">
                            <i data-lucide="file-text" class="w-4 h-4 mr-3 {{ request()->routeIs('admin.articles.*') ? 'text-blue-300' : 'text-slate-400' }}"></i>
                            <span>Manajemen Berita</span>
                        </div>
                        @php $pendingCount = \App\Models\Article::whereIn('status', ['submitted', 'under_review'])->count(); @endphp
                        @if($pendingCount > 0)
                            <span class="bg-amber-500 text-slate-900 font-bold px-1.5 py-0.5 rounded text-2xs">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.assignments.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.assignments.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="calendar" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Penugasan Liputan</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.categories.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="folder" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Kategori Berita</span>
                    </a>

                    <a href="{{ route('admin.tags.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.tags.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="hash" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Tag Topik</span>
                    </a>

                    <div class="pt-3 pb-1 px-3 text-slate-400 uppercase tracking-wider text-2xs font-bold">
                        Multimedia & Dokumentasi
                    </div>

                    <a href="{{ route('admin.media.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.media.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="image" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Media Library</span>
                    </a>

                    <a href="{{ route('admin.galleries.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.galleries.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="images" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Galeri Foto</span>
                    </a>

                    <a href="{{ route('admin.videos.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.videos.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="video" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Video Liputan</span>
                    </a>

                    <a href="{{ route('admin.podcasts.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.podcasts.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="mic" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Podcast SPELAND</span>
                    </a>

                    <a href="{{ route('admin.special-coverages.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.special-coverages.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layers" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Liputan Khusus</span>
                    </a>

                    <div class="pt-3 pb-1 px-3 text-slate-400 uppercase tracking-wider text-2xs font-bold">
                        Interaksi & Pembaca
                    </div>

                    <a href="{{ route('admin.comments.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.comments.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <div class="flex items-center">
                            <i data-lucide="message-square" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span>Komentar & Moderasi</span>
                        </div>
                        @php $pendingComments = \App\Models\Comment::where('status', 'pending')->count(); @endphp
                        @if($pendingComments > 0)
                            <span class="bg-red-500 text-white font-bold px-1.5 py-0.5 rounded text-2xs">
                                {{ $pendingComments }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.analytics.index') }}" 
                       class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.analytics.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="bar-chart-2" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Analitik Berita</span>
                    </a>

                    @if(auth()->user()->isPemimpinRedaksi())
                        <div class="pt-3 pb-1 px-3 text-slate-400 uppercase tracking-wider text-2xs font-bold">
                            Tata Kelola Sistem
                        </div>

                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="users" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span>Pengguna & Role</span>
                        </a>

                        <a href="{{ route('admin.editorial-members.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.editorial-members.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="award" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span>Struktur Redaksi</span>
                        </a>

                        <a href="{{ route('admin.activity-logs.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="activity" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span>Activity Logs</span>
                        </a>

                        <a href="{{ route('admin.settings.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'bg-blue-900 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="settings" class="w-4 h-4 mr-3 text-slate-400"></i>
                            <span>Pengaturan Portal</span>
                        </a>
                    @endif

                </nav>

                <!-- User Footer in Sidebar -->
                <div class="p-4 border-t border-slate-800 bg-slate-950/50">
                    <div class="flex items-center space-x-3">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                        <div class="flex-grow overflow-hidden">
                            <span class="font-bold text-xs text-white block truncate">{{ auth()->user()->name }}</span>
                            <span class="text-2xs text-blue-400 block truncate">{{ auth()->user()->role->name ?? 'Staf Redaksi' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN ADMIN CONTENT AREA -->
        <div class="flex-grow flex flex-col h-screen overflow-hidden">
            
            <!-- Top Admin Bar -->
            <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex items-center justify-between shrink-0">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-slate-900">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-base sm:text-lg font-bold text-slate-800">
                        @yield('page_title', 'Dashboard Redaksi')
                    </h1>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center text-xs font-semibold text-slate-600 hover:text-blue-900 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition">
                        <i data-lucide="external-link" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>Lihat Portal Publik</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition flex items-center">
                            <i data-lucide="log-out" class="w-3.5 h-3.5 mr-1"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mx-6 mt-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-2 text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 p-3.5 bg-red-50 border border-red-200 text-red-800 text-xs rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-2 text-red-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Body Content Area -->
            <main class="flex-grow p-4 sm:p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>

    </div>

    <!-- Scripts -->
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
