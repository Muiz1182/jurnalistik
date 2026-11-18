<footer class="bg-slate-900 text-slate-300 border-t-4 border-blue-900 pt-12 pb-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-10 border-b border-slate-800">
            
            <!-- Col 1: Identity & Description -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-900 text-white rounded-lg flex items-center justify-center font-extrabold text-lg border-b-2 border-red-500">
                        JS
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-white block leading-none">
                            JURNALISTIK <span class="text-blue-400">SPELAND</span>
                        </span>
                        <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold block mt-1">
                            SMP Negeri 9 Probolinggo
                        </span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    {{ \App\Models\Setting::get('about_brief', 'Jurnalistik SPELAND merupakan media informasi, komunikasi, dan publikasi digital resmi SMP Negeri 9 Probolinggo yang dikelola oleh tim jurnalis pelajar sekolah.') }}
                </p>
                <div class="flex items-center space-x-3 text-slate-400 pt-2">
                    <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-900 hover:text-white transition">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition">
                        <i data-lucide="youtube" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Kanal Berita -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider border-b border-slate-800 pb-2 mb-3">
                    Kanal Berita
                </h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="{{ route('articles.category', 'pendidikan') }}" class="hover:text-blue-400 transition">Pendidikan</a></li>
                    <li><a href="{{ route('articles.category', 'sekolah') }}" class="hover:text-blue-400 transition">Kabar Sekolah</a></li>
                    <li><a href="{{ route('articles.category', 'prestasi') }}" class="hover:text-blue-400 transition">Prestasi & Kejuaraan</a></li>
                    <li><a href="{{ route('articles.category', 'kegiatan') }}" class="hover:text-blue-400 transition">Agenda & Kegiatan</a></li>
                    <li><a href="{{ route('articles.category', 'lingkungan') }}" class="hover:text-blue-400 transition">Adiwiyata & Lingkungan</a></li>
                    <li><a href="{{ route('articles.opinion') }}" class="hover:text-blue-400 transition">Opini & Esai Murid</a></li>
                </ul>
            </div>

            <!-- Col 3: Redaksi & Regulasi -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider border-b border-slate-800 pb-2 mb-3">
                    Redaksi & Kebijakan
                </h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition">Profil Jurnalistik SPELAND</a></li>
                    <li><a href="{{ route('editorial.structure') }}" class="hover:text-blue-400 transition">Struktur Redaksi</a></li>
                    <li><a href="{{ route('editorial.policy') }}" class="hover:text-blue-400 transition">Kebijakan Redaksi</a></li>
                    <li><a href="{{ route('journalistic.guidelines') }}" class="hover:text-blue-400 transition">Pedoman Pemberitaan Media Siber</a></li>
                    <li><a href="{{ route('multimedia.special-coverages') }}" class="hover:text-blue-400 transition">Liputan Khusus</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-400 transition">Kirim Naskah / Kontak</a></li>
                </ul>
            </div>

            <!-- Col 4: Informasi Kontak Sekolah -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider border-b border-slate-800 pb-2 mb-3">
                    Sekretariat Redaksi
                </h4>
                <div class="space-y-2.5 text-xs text-slate-400 leading-relaxed">
                    <p class="font-semibold text-slate-200">
                        {{ \App\Models\Setting::get('school_name', 'SMP Negeri 9 Probolinggo') }}
                    </p>
                    <p class="flex items-start">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2 shrink-0 text-slate-500 mt-0.5"></i>
                        <span>{{ \App\Models\Setting::get('school_address', 'Jl. Mastrip No. 123, Kanigaran, Kota Probolinggo') }}</span>
                    </p>
                    <p class="flex items-center">
                        <i data-lucide="mail" class="w-4 h-4 mr-2 shrink-0 text-slate-500"></i>
                        <span>{{ \App\Models\Setting::get('editorial_email', 'redaksi.speland@gmail.com') }}</span>
                    </p>
                    <p class="flex items-center">
                        <i data-lucide="phone" class="w-4 h-4 mr-2 shrink-0 text-slate-500"></i>
                        <span>{{ \App\Models\Setting::get('school_phone', '(0335) 421999') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright & Credits -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-y-2">
            <div>
                &copy; {{ date('Y') }} <strong>JURNALISTIK SPELAND</strong>. Seluruh Hak Cipta Dilindungi Undang-Undang.
            </div>
            <div class="flex items-center space-x-4">
                <span>Media Publikasi Resmi SMPN 9 Probolinggo</span>
                <span>&bull;</span>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-400">Portal Redaksi</a>
            </div>
        </div>
    </div>
</footer>
