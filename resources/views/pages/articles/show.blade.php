@extends('layouts.app')

@section('title', $article->seo_title ?: $article->title . ' - JURNALISTIK SPELAND')
@section('meta_description', $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160)))
@section('og_image', $article->featured_image_url)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- BREADCRUMB -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-4" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-900 font-medium">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
        <a href="{{ route('articles.category', $article->category->slug) }}" class="hover:text-blue-900 font-medium text-blue-900 uppercase">
            {{ $article->category->name }}
        </a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
        <span class="text-slate-700 truncate max-w-xs">{{ $article->title }}</span>
    </nav>

    <!-- TWO-COLUMN EDITORIAL LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- MAIN ARTICLE COLUMN (8 Cols) -->
        <div class="lg:col-span-8 bg-white">
            
            <header class="mb-6">
                <!-- Category Tag & Breaking Indicator -->
                <div class="flex items-center gap-2 mb-3">
                    <a href="{{ route('articles.category', $article->category->slug) }}" 
                       class="bg-blue-950 text-white text-xs font-extrabold uppercase px-3 py-1 rounded tracking-wider">
                        {{ $article->category->name }}
                    </a>
                    @if($article->is_breaking)
                        <span class="bg-red-600 text-white text-xs font-bold uppercase px-2.5 py-1 rounded">
                            Breaking News
                        </span>
                    @endif
                </div>

                <!-- Main Title -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight tracking-tight">
                    {{ $article->title }}
                </h1>

                <!-- Subtitle -->
                @if($article->subtitle)
                    <p class="text-base sm:text-lg text-slate-700 font-medium mt-2 leading-snug">
                        {{ $article->subtitle }}
                    </p>
                @endif

                <!-- Byline & Metadata Grid -->
                <div class="flex flex-wrap items-center justify-between gap-y-3 py-4 mt-4 border-y border-slate-200 text-xs text-slate-600">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                        <div>
                            <div class="font-bold text-slate-900 text-sm">{{ $article->author->name }}</div>
                            <div class="text-slate-500">
                                <span>Reporter</span>
                                @if($article->photographer_name)
                                    <span> &bull; Foto: {{ $article->photographer_name }}</span>
                                @endif
                                @if($article->editor)
                                    <span> &bull; Editor: {{ $article->editor->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="font-medium text-slate-700">
                            {{ $article->published_at ? $article->published_at->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : 'Draft Redaksi' }}
                        </div>
                        <div class="flex items-center justify-end space-x-3 text-slate-400 mt-0.5">
                            <span class="flex items-center">
                                <i data-lucide="eye" class="w-3.5 h-3.5 mr-1"></i>
                                {{ number_format($article->views_count) }} dibaca
                            </span>
                            <span>&bull;</span>
                            <span>{{ $article->reading_time }} mnt baca</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Featured Image & Caption -->
            @if($article->featured_image)
                <figure class="mb-6">
                    <div class="overflow-hidden rounded-xl bg-slate-100 shadow-sm aspect-[16/10]">
                        <img src="{{ $article->featured_image_url }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @if($article->image_caption)
                        <figcaption class="text-xs text-slate-500 mt-2 px-1 italic flex items-center">
                            <i data-lucide="camera" class="w-3.5 h-3.5 mr-1.5 shrink-0 text-slate-400"></i>
                            <span>{{ $article->image_caption }}</span>
                        </figcaption>
                    @endif
                </figure>
            @endif

            <!-- Article Body Content -->
            <div class="font-editorial text-base sm:text-lg text-slate-800 leading-relaxed space-y-5 prose prose-slate max-w-none prose-p:leading-relaxed prose-headings:font-sans prose-headings:font-bold prose-headings:text-slate-900 prose-img:rounded-xl">
                {!! $article->content !!}
            </div>

            <!-- Tags Bar -->
            @if($article->tags->isNotEmpty())
                <div class="mt-8 pt-4 border-t border-slate-200 flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold text-slate-500 mr-2 flex items-center">
                        <i data-lucide="tag" class="w-3.5 h-3.5 mr-1"></i>
                        Topik Terkait:
                    </span>
                    @foreach($article->tags as $tag)
                        <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}" 
                           class="text-xs font-semibold bg-slate-100 hover:bg-blue-900 hover:text-white text-slate-700 px-3 py-1.5 rounded-full transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Interaction & Share Bar -->
            <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-wrap items-center justify-between gap-4">
                
                <!-- Share Buttons -->
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-slate-600 mr-1">Bagikan:</span>
                    
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" 
                       target="_blank" 
                       rel="noopener"
                       class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 transition" 
                       title="Bagikan ke WhatsApp">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       rel="noopener"
                       class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition" 
                       title="Bagikan ke Facebook">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>

                    <!-- X / Twitter -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       rel="noopener"
                       class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-black transition" 
                       title="Bagikan ke X">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>

                    <!-- Copy Link -->
                    <button type="button" 
                            x-data="{ copied: false }" 
                            @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" 
                            class="flex items-center text-xs font-semibold bg-white border border-slate-300 px-3 py-1.5 rounded-lg text-slate-700 hover:bg-slate-100 transition">
                        <i data-lucide="link" class="w-3.5 h-3.5 mr-1.5 text-slate-500"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'"></span>
                    </button>
                </div>

                <!-- Bookmark Button -->
                <div>
                    @auth
                        <form action="{{ route('articles.bookmark', $article) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center text-xs font-semibold px-4 py-2 rounded-lg transition {{ $isBookmarked ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-100' }}">
                                <i data-lucide="bookmark" class="w-3.5 h-3.5 mr-1.5 {{ $isBookmarked ? 'fill-current text-amber-600' : '' }}"></i>
                                <span>{{ $isBookmarked ? 'Tersimpan' : 'Simpan Berita' }}</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center text-xs font-semibold bg-white text-slate-600 border border-slate-300 px-3.5 py-1.5 rounded-lg hover:bg-slate-100 transition" title="Masuk untuk menyimpan artikel">
                            <i data-lucide="bookmark" class="w-3.5 h-3.5 mr-1.5"></i>
                            <span>Simpan</span>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->isNotEmpty())
                <div class="mt-10 pt-8 border-t border-slate-200">
                    <h3 class="font-extrabold text-lg text-slate-900 border-b-2 border-blue-950 pb-2 mb-4">
                        Berita Terkait di {{ $article->category->name }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($relatedArticles as $related)
                            <x-article-card :article="$related" layout="horizontal" />
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comments Section with Moderation -->
            <section class="mt-12 pt-8 border-t border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-extrabold text-slate-900 flex items-center">
                        <i data-lucide="message-square" class="w-5 h-5 mr-2 text-blue-900"></i>
                        Komentar Pembaca ({{ $article->approvedComments->count() }})
                    </h3>
                    <span class="text-xs text-slate-400">Seluruh komentar dimoderasi redaksi</span>
                </div>

                @if($article->allow_comments)
                    <!-- Comment Input Form -->
                    <form action="{{ route('comments.store', $article) }}" method="POST" class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-8">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                                <input type="email" name="email" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Isi Komentar / Tanggapan *</label>
                            <textarea name="content" rows="3" required placeholder="Tuliskan komentar yang santun dan membangun..." class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('content') }}</textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500 italic">Komentar akan diverifikasi terlebih dahulu sesuai etika media ramah anak.</span>
                            <button type="submit" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs px-5 py-2.5 rounded-lg transition shadow-sm">
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-slate-100 p-4 rounded-lg text-xs text-slate-500 italic text-center mb-6">
                        Kolom komentar untuk artikel ini ditutup.
                    </div>
                @endif

                <!-- Comments Display List -->
                <div class="space-y-4">
                    @forelse($article->approvedComments as $comment)
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-950 text-white flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-xs text-slate-900">{{ $comment->name }}</span>
                                </div>
                                <span class="text-xs text-slate-400">
                                    {{ $comment->created_at->locale('id')->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed pl-9">
                                {{ $comment->content }}
                            </p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic py-2">Belum ada komentar untuk berita ini. Jadilah yang pertama memberikan tanggapan!</p>
                    @endforelse
                </div>
            </section>
        </div>

        <!-- SIDEBAR (4 Cols) -->
        <aside class="lg:col-span-4 space-y-6">
            <!-- Popular Articles -->
            <x-sidebar-popular :popularArticles="$popularArticles" />

            <!-- Editorial Board Contact Pill -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                <h4 class="font-bold text-sm text-slate-900 uppercase tracking-wider mb-2 flex items-center">
                    <i data-lucide="shield-check" class="w-4 h-4 mr-1.5 text-blue-900"></i>
                    Pedoman Hak Jawab
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Sesuai dengan Kode Etik Jurnalistik dan Pedoman Pemberitaan Media Siber, redaksi Jurnalistik SPELAND melayani hak jawab dan koreksi fakta dari pembaca.
                </p>
                <a href="{{ route('journalistic.guidelines') }}" class="text-xs font-bold text-blue-900 hover:underline mt-2 inline-block">
                    Baca Pedoman Pemberitaan &rarr;
                </a>
            </div>
        </aside>

    </div>
</div>
@endsection
