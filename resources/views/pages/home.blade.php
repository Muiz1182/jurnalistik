@extends('layouts.app')

@section('title', 'JURNALISTIK SPELAND | Portal Berita Digital Resmi SMP Negeri 9 Probolinggo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-10">

    <!-- 1. HERO HEADLINE & TOP STORIES SECTION -->
    <section class="border-b border-slate-200 pb-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Main Hero Headline (8 Columns) -->
            @if($heroHeadline)
                <div class="lg:col-span-8 group">
                    <article class="flex flex-col">
                        <!-- Dominant Image -->
                        <div class="relative aspect-[16/9] w-full overflow-hidden rounded-xl bg-slate-100 shadow-sm mb-4">
                            <a href="{{ route('articles.show', $heroHeadline->slug) }}" class="block w-full h-full">
                                <img src="{{ $heroHeadline->featured_image_url }}" 
                                     alt="{{ $heroHeadline->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-102 transition duration-500 ease-out">
                            </a>
                            <div class="absolute top-4 left-4 flex gap-2">
                                <a href="{{ route('articles.category', $heroHeadline->category->slug) }}" 
                                   class="bg-blue-950 text-white text-xs font-extrabold uppercase px-3 py-1.5 rounded tracking-wider shadow">
                                    {{ $heroHeadline->category->name }}
                                </a>
                                @if($heroHeadline->is_breaking)
                                    <span class="bg-red-600 text-white text-xs font-bold uppercase px-2.5 py-1.5 rounded shadow">
                                        Breaking
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Headline Info -->
                        <div>
                            <div class="flex items-center text-xs text-slate-500 space-x-3 mb-2 font-medium">
                                <span class="text-slate-800 font-semibold">{{ $heroHeadline->author->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $heroHeadline->published_at ? $heroHeadline->published_at->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : '' }}</span>
                                <span>&bull;</span>
                                <span class="flex items-center">
                                    <i data-lucide="eye" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                                    {{ number_format($heroHeadline->views_count) }} dibaca
                                </span>
                            </div>

                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 group-hover:text-blue-900 transition leading-tight tracking-tight">
                                <a href="{{ route('articles.show', $heroHeadline->slug) }}">
                                    {{ $heroHeadline->title }}
                                </a>
                            </h1>

                            @if($heroHeadline->subtitle)
                                <h2 class="text-base sm:text-lg text-slate-700 font-medium mt-2 leading-snug">
                                    {{ $heroHeadline->subtitle }}
                                </h2>
                            @endif

                            @if($heroHeadline->excerpt)
                                <p class="text-sm text-slate-600 mt-3 leading-relaxed line-clamp-3">
                                    {{ $heroHeadline->excerpt }}
                                </p>
                            @endif

                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('articles.show', $heroHeadline->slug) }}" 
                                   class="inline-flex items-center text-sm font-bold text-blue-950 hover:text-blue-700 transition">
                                    <span>Baca Selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5"></i>
                                </a>
                                <span class="text-xs text-slate-400 font-medium">
                                    Waktu baca: ~{{ $heroHeadline->reading_time }} menit
                                </span>
                            </div>
                        </div>
                    </article>
                </div>
            @endif

            <!-- Secondary Headlines Column (4 Columns) -->
            <div class="lg:col-span-4 space-y-6 lg:border-l lg:border-slate-200 lg:pl-8">
                <div class="border-b-2 border-blue-950 pb-2 mb-4">
                    <h2 class="font-extrabold text-sm uppercase tracking-wider text-slate-900 flex items-center">
                        <i data-lucide="sparkles" class="w-4 h-4 mr-1.5 text-blue-900"></i>
                        Sorotan Redaksi
                    </h2>
                </div>

                <div class="space-y-5">
                    @forelse($secondaryHeadlines as $secondary)
                        <article class="group pb-5 border-b border-slate-100 last:border-0 last:pb-0">
                            <a href="{{ route('articles.category', $secondary->category->slug) }}" 
                               class="text-xs font-bold text-blue-900 uppercase tracking-wider block mb-1">
                                {{ $secondary->category->name }}
                            </a>
                            <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-900 transition leading-snug">
                                <a href="{{ route('articles.show', $secondary->slug) }}">
                                    {{ $secondary->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                {{ $secondary->excerpt }}
                            </p>
                            <div class="flex items-center text-xs text-slate-400 mt-2 space-x-2">
                                <span>{{ $secondary->author->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $secondary->published_at ? $secondary->published_at->locale('id')->diffForHumans() : '' }}</span>
                            </div>
                        </article>
                    @empty
                        <p class="text-xs text-slate-500 italic">Belum ada sorotan redaksi tambahan.</p>
                    @endforelse
                </div>

                <!-- Editorial Announcement Pill -->
                <div class="bg-blue-50 border border-blue-200/80 rounded-xl p-4 mt-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-950 flex items-center mb-1">
                        <i data-lucide="info" class="w-3.5 h-3.5 mr-1.5 text-blue-700"></i>
                        Ruang Redaksi SPELAND
                    </span>
                    <p class="text-xs text-blue-900 leading-relaxed">
                        Punya liputan kegiatan kelas atau karya puisi? Kirimkan naskah Anda ke meja redaksi melalui kontak redaksi.
                    </p>
                    <a href="{{ route('contact') }}" class="text-xs font-bold text-blue-950 hover:underline mt-2 inline-block">
                        Hubungi Tim Redaksi &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. BERITA TERBARU GRID & SIDEBAR POPULER SECTION -->
    <section>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Latest News Grid (8 Columns) -->
            <div class="lg:col-span-8">
                <div class="flex items-center justify-between border-b-2 border-blue-950 pb-3 mb-6">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center">
                        <span class="w-3 h-3 bg-blue-950 mr-2 rounded-xs"></span>
                        Berita Terbaru
                    </h2>
                    <a href="{{ route('articles.latest') }}" class="text-xs font-bold text-blue-900 hover:underline flex items-center">
                        <span>Indeks Berita</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($latestArticles as $article)
                        <x-article-card :article="$article" />
                    @empty
                        <div class="col-span-2 py-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <i data-lucide="newspaper" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                            <p class="text-sm font-medium text-slate-600">Belum ada berita terbaru yang diterbitkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Sidebar: Berita Terpopuler (4 Columns) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Popular News Widget -->
                <x-sidebar-popular :popularArticles="$popularArticles" />

                <!-- Podcast Spotlight Box -->
                @if($podcasts->isNotEmpty())
                    @php $firstPodcast = $podcasts->first(); @endphp
                    <div class="bg-slate-900 text-white rounded-xl p-5 shadow-sm border border-slate-800">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2 mb-3">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-red-400 flex items-center">
                                <i data-lucide="mic" class="w-3.5 h-3.5 mr-1.5"></i>
                                Podcast SPELAND
                            </span>
                            <span class="text-xs text-slate-400">Ep. {{ $firstPodcast->episode_number }}</span>
                        </div>
                        <h4 class="font-bold text-sm text-white leading-snug line-clamp-2">
                            {{ $firstPodcast->title }}
                        </h4>
                        <div class="text-xs text-slate-400 mt-2 space-y-0.5">
                            <p>Host: {{ $firstPodcast->host }}</p>
                            @if($firstPodcast->guest)
                                <p>Narasumber: {{ $firstPodcast->guest }}</p>
                            @endif
                        </div>
                        <a href="{{ route('multimedia.podcasts') }}" class="mt-4 block w-full text-center bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-lg transition">
                            Dengarkan Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 3. KATEGORI KHUSUS: PENDIDIKAN & PRESTASI -->
    <section class="border-t border-slate-200 pt-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Section Pendidikan -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between border-b-2 border-blue-900 pb-3 mb-4">
                    <h2 class="text-lg font-extrabold text-blue-950 uppercase tracking-wider flex items-center">
                        <i data-lucide="book-open" class="w-4 h-4 mr-2 text-blue-900"></i>
                        Pendidikan
                    </h2>
                    <a href="{{ route('articles.category', 'pendidikan') }}" class="text-xs font-bold text-blue-900 hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($pendidikanArticles as $pArt)
                        <x-article-card :article="$pArt" layout="horizontal" />
                    @empty
                        <p class="text-xs text-slate-500 italic py-4">Belum ada artikel di kategori Pendidikan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Section Prestasi -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between border-b-2 border-amber-600 pb-3 mb-4">
                    <h2 class="text-lg font-extrabold text-slate-900 uppercase tracking-wider flex items-center">
                        <i data-lucide="trophy" class="w-4 h-4 mr-2 text-amber-600"></i>
                        Prestasi & Kejuaraan
                    </h2>
                    <a href="{{ route('articles.category', 'prestasi') }}" class="text-xs font-bold text-blue-900 hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($prestasiArticles as $prArt)
                        <x-article-card :article="$prArt" layout="horizontal" />
                    @empty
                        <p class="text-xs text-slate-500 italic py-4">Belum ada artikel di kategori Prestasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- 4. OPINI & ESAI MURID SECTION -->
    <section class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 pb-4 mb-6 gap-y-2">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-orange-600 block">Ruang Gagasan</span>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Opini & Esai Murid</h2>
            </div>
            <a href="{{ route('articles.opinion') }}" class="text-xs font-bold text-blue-900 hover:underline flex items-center">
                <span>Semua Tulisan Opini</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($opiniArticles as $opini)
                <article class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-3">
                            <img src="{{ $opini->author->avatar_url }}" alt="{{ $opini->author->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                            <div>
                                <h4 class="font-bold text-xs text-slate-900">{{ $opini->author->name }}</h4>
                                <span class="text-xs text-slate-400 block">{{ $opini->author->title ?? 'Penulis Opini' }}</span>
                            </div>
                        </div>
                        <h3 class="font-bold text-base text-slate-900 hover:text-blue-900 transition leading-snug">
                            <a href="{{ route('articles.show', $opini->slug) }}">
                                &ldquo;{{ $opini->title }}&rdquo;
                            </a>
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                            {{ $opini->excerpt }}
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $opini->published_at ? $opini->published_at->locale('id')->isoFormat('D MMM Y') : '' }}</span>
                        <a href="{{ route('articles.show', $opini->slug) }}" class="text-blue-900 font-bold hover:underline">
                            Baca Esai &rarr;
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-6 text-slate-500 text-xs italic">
                    Belum ada tulisan opini yang dimuat.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. MULTIMEDIA SECTION: GALERI, VIDEO & PODCAST -->
    <section class="border-t border-slate-200 pt-10">
        <div class="flex items-center justify-between border-b-2 border-blue-950 pb-3 mb-6">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center">
                <i data-lucide="video" class="w-5 h-5 mr-2 text-red-600"></i>
                Multimedia & Dokumentasi
            </h2>
            <div class="flex space-x-3 text-xs font-semibold">
                <a href="{{ route('multimedia.galleries') }}" class="text-slate-600 hover:text-blue-900">Galeri</a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('multimedia.videos') }}" class="text-slate-600 hover:text-blue-900">Video</a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('multimedia.podcasts') }}" class="text-slate-600 hover:text-blue-900">Podcast</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Galleries -->
            @foreach($galleries->take(1) as $gal)
                <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                    <a href="{{ route('multimedia.gallery.show', $gal->slug) }}" class="block aspect-video bg-slate-100 relative overflow-hidden">
                        <img src="{{ $gal->cover_image_url }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <span class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-xs font-bold px-2 py-1 rounded flex items-center">
                            <i data-lucide="camera" class="w-3.5 h-3.5 mr-1"></i>
                            {{ $gal->photos_count }} Foto
                        </span>
                    </a>
                    <div class="p-4">
                        <span class="text-xs font-bold text-blue-900 uppercase tracking-wider block mb-1">Galeri Foto</span>
                        <h3 class="font-bold text-sm text-slate-900 group-hover:text-blue-900 transition leading-snug line-clamp-2">
                            <a href="{{ route('multimedia.gallery.show', $gal->slug) }}">{{ $gal->title }}</a>
                        </h3>
                    </div>
                </div>
            @endforeach

            <!-- Videos -->
            @foreach($videos->take(2) as $vid)
                <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-video bg-slate-900 relative">
                        <iframe class="w-full h-full" 
                                src="{{ $vid->embed_url }}" 
                                title="{{ $vid->title }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-red-600 uppercase tracking-wider block mb-1">{{ $vid->category }}</span>
                        <h3 class="font-bold text-sm text-slate-900 leading-snug line-clamp-2">
                            {{ $vid->title }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
