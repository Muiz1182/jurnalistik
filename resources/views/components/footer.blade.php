<footer class="bg-slate-950 text-slate-300 border-t border-slate-800 mt-16">
    <!-- Main Footer Columns -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            
            <!-- Brand & Identity (2 Columns) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center space-x-3">
                    @if(\App\Models\Setting::get('site_logo'))
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-white p-0.5 border border-slate-700 shadow-md shrink-0">
                            <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-xl bg-blue-900 text-white flex items-center justify-center font-serif font-black text-lg border-b-2 border-red-500 shadow-md shrink-0">
                            JS
                        </div>
                    @endif
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

                <!-- Social Media Channels -->
                <div class="pt-3 border-t border-slate-800/80 space-y-2">
                    <span class="text-3xs uppercase tracking-wider text-slate-400 font-extrabold block">
                        Kanal Media Sosial Resmi
                    </span>
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- TikTok -->
                        <a href="{{ \App\Models\Setting::get('social_tiktok', \App\Models\Setting::get('social_facebook', '#')) }}" 
                           target="_blank" 
                           rel="noopener" 
                           class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-slate-900/90 hover:bg-slate-800 border border-slate-800 hover:border-cyan-400/60 text-slate-200 hover:text-white transition shadow-xs text-xs font-semibold group" 
                           title="TikTok Resmi SPELAND">
                            <svg class="w-4 h-4 text-cyan-400 group-hover:text-pink-400 transition shrink-0 fill-current" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.27 6.27 0 0 0 1.9-4.49V8.75a8.16 8.16 0 0 0 4.87 1.58V6.89c-.338-.002-.676-.07-1-.2z"/>
                            </svg>
                            <span class="text-xs">TikTok</span>
                        </a>

                        <!-- Instagram -->
                        <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" 
                           target="_blank" 
                           rel="noopener" 
                           class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-slate-900/90 hover:bg-slate-800 border border-slate-800 hover:border-pink-400/60 text-slate-200 hover:text-white transition shadow-xs text-xs font-semibold group" 
                           title="Instagram Resmi">
                            <svg class="w-4 h-4 text-pink-400 group-hover:text-pink-300 transition shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                            </svg>
                            <span class="text-xs">Instagram</span>
                        </a>

                        <!-- YouTube -->
                        <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" 
                           target="_blank" 
                           rel="noopener" 
                           class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-slate-900/90 hover:bg-slate-800 border border-slate-800 hover:border-red-400/60 text-slate-200 hover:text-white transition shadow-xs text-xs font-semibold group" 
                           title="Kanal YouTube SMPN 9">
                            <svg class="w-4 h-4 text-red-500 group-hover:text-red-400 transition shrink-0 fill-current" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            <span class="text-xs">YouTube</span>
                        </a>
                    </div>
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
                Hak Cipta &copy; {{ date('Y') }} <span class="text-slate-300 font-semibold">JURNALISTIK SPELAND</span> - SMP Negeri 9 Probolinggo. Seluruh hak cipta dilindungi undang-undang.
            </p>
            <p class="text-3xs text-slate-400">
                Media Pers & Publikasi Digital Resmi Sekolah
            </p>
        </div>
    </div>
</footer>
