<footer class="bg-slate-950 text-slate-300 border-t border-slate-800 mt-16">
    <!-- Main Footer Columns -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            
            <!-- Brand & Identity (2 Columns) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-900 text-white flex items-center justify-center font-serif font-black text-lg border-b-2 border-red-500 shadow-md">
                        JS
                    </div>
                    <div>
                        <span class="text-lg font-black text-white tracking-tight block leading-none">
                            JURNALISTIK <span class="text-blue-400">SPELAND</span>
                        </span>
                        <span class="text-3xs uppercase tracking-wider text-red-400 font-extrabold mt-0.5 block">
                            SMP Negeri 9 Probolinggo
                        </span>
                    </div>
                </div>

                <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                    Platform pers digital dan laboratorium literasi resmi SMP Negeri 9 Probolinggo. Mendidik jurnalis pelajar berintegritas, mandiri, dan berani mengabarkan fakta demi kemajuan pendidikan.
                </p>

                <div class="space-y-1 text-xs text-slate-400">
                    <p class="flex items-start">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-2 mt-0.5 text-blue-400 shrink-0"></i>
                        <span>{{ \App\Models\Setting::get('school_address', 'Jl. Mastrip No. 123, Kanigaran, Kota Probolinggo') }}</span>
                    </p>
                    <p class="flex items-center">
                        <i data-lucide="mail" class="w-3.5 h-3.5 mr-2 text-blue-400 shrink-0"></i>
                        <span>{{ \App\Models\Setting::get('editorial_email', 'redaksi.speland@gmail.com') }}</span>
                    </p>
                    <p class="flex items-center">
                        <i data-lucide="phone" class="w-3.5 h-3.5 mr-2 text-blue-400 shrink-0"></i>
                        <span>{{ \App\Models\Setting::get('school_phone', '(0335) 421999') }}</span>
                    </p>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-pink-600 text-slate-400 hover:text-white flex items-center justify-center transition shadow-xs" title="Instagram">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-red-600 text-slate-400 hover:text-white flex items-center justify-center transition shadow-xs" title="YouTube">
                        <i data-lucide="youtube" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition shadow-xs" title="Facebook">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Rubrik Berita -->
            <div class="space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-white border-l-2 border-red-500 pl-2.5">
                    Rubrik Utama
                </h4>
                <ul class="space-y-2 text-xs text-slate-400 font-medium">
                    <li><a href="{{ route('articles.category', 'pendidikan') }}" class="hover:text-white transition">Pendidikan & Pembelajaran</a></li>
                    <li><a href="{{ route('articles.category', 'prestasi') }}" class="hover:text-white transition">Prestasi & Kejuaraan</a></li>
                    <li><a href="{{ route('articles.category', 'kegiatan') }}" class="hover:text-white transition">Kegiatan & Ekstrakurikuler</a></li>
                    <li><a href="{{ route('articles.category', 'lingkungan') }}" class="hover:text-white transition">Adiwiyata & Lingkungan</a></li>
                    <li><a href="{{ route('articles.category', 'literasi') }}" class="hover:text-white transition">Pojok Literasi & Resensi</a></li>
                    <li><a href="{{ route('articles.opinion') }}" class="hover:text-white transition">Opini Murid & Esai Guru</a></li>
                </ul>
            </div>

            <!-- Multimedia & Liputan Khusus -->
            <div class="space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-white border-l-2 border-blue-500 pl-2.5">
                    Multimedia
                </h4>
                <ul class="space-y-2 text-xs text-slate-400 font-medium">
                    <li><a href="{{ route('multimedia.galleries') }}" class="hover:text-white transition">Galeri Foto Sekolah</a></li>
                    <li><a href="{{ route('multimedia.videos') }}" class="hover:text-white transition">Video Dokumentasi</a></li>
                    <li><a href="{{ route('multimedia.podcasts') }}" class="hover:text-white transition">Podcast SPELAND</a></li>
                    <li><a href="{{ route('multimedia.special-coverages') }}" class="hover:text-white transition">Liputan Khusus / Dossier</a></li>
                    <li><a href="{{ route('articles.popular') }}" class="hover:text-white transition">Artikel Terpopuler 🔥</a></li>
                    <li><a href="{{ route('articles.archive') }}" class="hover:text-white transition">Arsip Publikasi</a></li>
                </ul>
            </div>

            <!-- Standar Pers & Tata Kelola -->
            <div class="space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-white border-l-2 border-amber-500 pl-2.5">
                    Standar Redaksi
                </h4>
                <ul class="space-y-2 text-xs text-slate-400 font-medium">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Jurnalistik SPELAND</a></li>
                    <li><a href="{{ route('editorial.structure') }}" class="hover:text-white transition">Susunan Dewan Redaksi</a></li>
                    <li><a href="{{ route('editorial.policy') }}" class="hover:text-white transition">Kebijakan Redaksi</a></li>
                    <li><a href="{{ route('journalistic.guidelines') }}" class="hover:text-white transition">Pedoman Pemberitaan Ramah Anak</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Hak Jawab & Koreksi Berita</a></li>
                    <li><a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition font-bold">Portal Meja Redaksi &rarr;</a></li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Bottom Copyright Bar -->
    <div class="bg-slate-900 border-t border-slate-800/80 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-2xs text-slate-500 gap-2">
            <p>
                Hak Cipta &copy; {{ date('Y') }} <span class="text-slate-300 font-semibold">JURNALISTIK SPELAND</span> — SMP Negeri 9 Probolinggo. Seluruh hak cipta dilindungi undang-undang.
            </p>
            <p class="font-mono text-3xs text-slate-500">
                Edisi Pers Sekolah Modern &bull; PostgreSQL 18 Full-Text Engine
            </p>
        </div>
    </div>
</footer>
