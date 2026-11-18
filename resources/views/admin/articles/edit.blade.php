@extends('layouts.admin')

@section('title', 'Edit Artikel: ' . $article->title)
@section('page_title', 'Penyuntingan & Alur Redaksi Naskah')

@push('styles')
<!-- TinyMCE Rich Text Editor -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#article-content',
            height: 520,
            menubar: false,
            plugins: 'lists link image media table code wordcount',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist blockquote | link image media | code',
            content_style: "body { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; line-height: 1.7; color: #1e293b; }",
            branding: false
        });
    });
</script>
@endpush

@section('content')
<div class="space-y-6" x-data="{ revisionModalOpen: false }">

    <!-- WORKFLOW STATUS BAR -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <div class="flex items-center space-x-3">
            @php
                $statusColors = [
                    'draft' => 'bg-slate-100 text-slate-800 border-slate-300',
                    'submitted' => 'bg-amber-100 text-amber-800 border-amber-300',
                    'under_review' => 'bg-blue-100 text-blue-800 border-blue-300',
                    'revision_required' => 'bg-rose-100 text-rose-800 border-rose-300',
                    'approved' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                    'scheduled' => 'bg-purple-100 text-purple-800 border-purple-300',
                    'published' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    'archived' => 'bg-slate-200 text-slate-700 border-slate-300',
                ];
            @endphp
            <div class="text-xs uppercase font-extrabold px-3 py-1.5 rounded-lg border {{ $statusColors[$article->status] ?? 'bg-slate-100' }}">
                Status: {{ str_replace('_', ' ', $article->status) }}
            </div>

            <div class="text-xs text-slate-500">
                Penulis: <strong class="text-slate-800">{{ $article->author->name }}</strong>
                @if($article->editor)
                    &bull; Editor: <strong class="text-slate-800">{{ $article->editor->name }}</strong>
                @endif
            </div>
        </div>

        <!-- Workflow Decision Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            
            <!-- 1. Editor action: Submit to Kadiv for Approval -->
            @if(in_array($article->status, ['draft', 'revision_required']))
                <form action="{{ route('admin.articles.submit', $article) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition shadow-2xs flex items-center">
                        <i data-lucide="send" class="w-3.5 h-3.5 mr-1.5"></i>
                        Minta Persetujuan Kadiv
                    </button>
                </form>
            @endif

            <!-- 2. Kadiv actions: Start Review -->
            @if($article->status === 'submitted' && auth()->user()->canPublishArticles())
                <form action="{{ route('admin.articles.review', $article) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition shadow-2xs flex items-center">
                        <i data-lucide="search" class="w-3.5 h-3.5 mr-1.5"></i>
                        Tinjau Naskah
                    </button>
                </form>
            @endif

            <!-- 3. Kadiv actions: Request Revision -->
            @if(in_array($article->status, ['submitted', 'under_review']) && auth()->user()->canPublishArticles())
                <button type="button" 
                        @click="revisionModalOpen = true" 
                        class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition shadow-2xs flex items-center">
                    <i data-lucide="corner-up-left" class="w-3.5 h-3.5 mr-1.5"></i>
                    Kembalikan untuk Revisi
                </button>
            @endif

            <!-- 4. Kadiv actions: Approve & Publish Article -->
            @if(auth()->user()->canPublishArticles())
                @if($article->status !== 'published')
                    <form action="{{ route('admin.articles.publish', $article) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition shadow-2xs flex items-center">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 mr-1.5"></i>
                            Setujui & Terbitkan ke Website
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.articles.archive', $article) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition shadow-2xs flex items-center">
                            <i data-lucide="archive" class="w-3.5 h-3.5 mr-1.5"></i>
                            Arsipkan
                        </button>
                    </form>
                @endif
            @endif

            @if($article->status === 'published')
                <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold px-3.5 py-2 rounded-lg transition border border-slate-300 flex items-center">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 mr-1.5"></i>
                    Lihat Berita
                </a>
            @endif

        </div>

    </div>

    <!-- MAIN FORM & SETTINGS -->
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Form Left Column (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-5">
                    <div>
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Judul Berita *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               required 
                               value="{{ old('title', $article->title) }}" 
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-2.5 text-base font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>

                    <div>
                        <label for="subtitle" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Subjudul (Lead Pendukung)
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $article->subtitle) }}" 
                               class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>

                    <div>
                        <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Ringkasan / Excerpt
                        </label>
                        <textarea id="excerpt" 
                                  name="excerpt" 
                                  rows="3" 
                                  class="w-full bg-white border border-slate-300 rounded-lg p-3 text-xs leading-relaxed text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>

                    <div>
                        <label for="article-content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Isi Berita Lengkap *
                        </label>
                        <textarea id="article-content" name="content">{{ old('content', $article->content) }}</textarea>
                    </div>
                </div>

                <!-- SEO Box -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center">
                        <i data-lucide="globe" class="w-4 h-4 mr-2 text-blue-900"></i>
                        Optimasi Mesin Pencari (SEO)
                    </h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title', $article->seo_title) }}" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('meta_description', $article->meta_description) }}</textarea>
                    </div>
                </div>

                <!-- RIWAYAT REVISI & CATATAN REDAKSI (TIMELINE) -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center">
                        <i data-lucide="history" class="w-4 h-4 mr-2 text-blue-900"></i>
                        Riwayat Catatan Redaksi & Revisi ({{ $revisions->count() }})
                    </h3>

                    <div class="space-y-4">
                        @forelse($revisions as $rev)
                            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-lg">
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-bold text-slate-900">{{ $rev->user->name }} ({{ $rev->user->role->name ?? 'Staf' }})</span>
                                    <span class="text-slate-400">{{ $rev->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }} WIB</span>
                                </div>
                                <div class="text-2xs font-semibold text-blue-900 mb-1.5 uppercase">
                                    Status Diubah: {{ str_replace('_', ' ', $rev->from_status ?? 'Awal') }} &rarr; {{ str_replace('_', ' ', $rev->to_status) }}
                                </div>
                                @if($rev->notes)
                                    <p class="text-xs text-slate-700 bg-white p-2.5 rounded border border-slate-200 leading-relaxed">
                                        {{ $rev->notes }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">Belum ada catatan riwayat revisi.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Form Right Column (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Save Button Box -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-3">
                    <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                        Simpan Perubahan
                    </h3>
                    <button type="submit" class="w-full bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs py-3 rounded-lg transition shadow-sm flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 mr-1.5"></i>
                        <span>Simpan Perubahan Artikel</span>
                    </button>
                </div>

                <!-- Rubrik & Tags -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                        Kategori & Rubrik
                    </h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Kategori *</label>
                        <select name="category_id" required class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tag / Kata Kunci</label>
                        <div class="flex flex-wrap gap-1.5 mb-2">
                            @foreach($article->tags as $t)
                                <span class="bg-blue-50 text-blue-900 text-2xs font-bold px-2 py-0.5 rounded border border-blue-200">
                                    #{{ $t->name }}
                                </span>
                            @endforeach
                        </div>
                        <input type="text" 
                               name="tags_csv" 
                               value="{{ $article->tags->pluck('name')->implode(', ') }}" 
                               placeholder="Pisahkan dengan koma" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-xs text-slate-800">
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                        Foto Utama Berita
                    </h3>

                    @if($article->featured_image)
                        <div class="rounded-lg overflow-hidden border border-slate-200 aspect-[16/10] bg-slate-100">
                            <img src="{{ $article->featured_image_url }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Foto (Maks 3MB)</label>
                        <input type="file" 
                               name="featured_image" 
                               accept="image/*" 
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Caption Foto</label>
                        <input type="text" 
                               name="image_caption" 
                               value="{{ old('image_caption', $article->image_caption) }}" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-xs text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Fotografer</label>
                        <input type="text" 
                               name="photographer_name" 
                               value="{{ old('photographer_name', $article->photographer_name) }}" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-xs text-slate-800">
                    </div>
                </div>

                <!-- Additional Flags -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-3 text-xs">
                    <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                        Pengaturan Tambahan
                    </h3>

                    @if(auth()->user()->isPemimpinRedaksi())
                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" name="is_breaking" value="1" {{ $article->is_breaking ? 'checked' : '' }} class="rounded border-slate-300 text-red-600 focus:ring-red-600">
                            <span class="font-bold text-red-700">Tampilkan sebagai Breaking News</span>
                        </label>

                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" name="is_headline" value="1" {{ $article->is_headline ? 'checked' : '' }} class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                            <span class="font-semibold text-slate-800">Headline Utama Beranda</span>
                        </label>

                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ $article->is_featured ? 'checked' : '' }} class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                            <span class="font-semibold text-slate-800">Sorotan Khusus (Featured)</span>
                        </label>
                    @endif

                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" name="allow_comments" value="1" {{ $article->allow_comments ? 'checked' : '' }} class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                        <span class="font-semibold text-slate-800">Izinkan Komentar Pembaca</span>
                    </label>
                </div>

            </div>

        </div>
    </form>

    <!-- MODAL DIALOG: RETURN FOR REVISION -->
    <div x-show="revisionModalOpen" 
         x-cloak
         @keydown.escape.window="revisionModalOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="revisionModalOpen = false" class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-lg w-full p-6">
            <h3 class="text-base font-extrabold text-slate-900 mb-2 flex items-center">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 mr-2"></i>
                Catatan Revisi Naskah
            </h3>
            <p class="text-xs text-slate-600 mb-4">
                Tuliskan bagian mana yang perlu diperbaiki, diklarifikasi, atau disempurnakan oleh reporter.
            </p>

            <form action="{{ route('admin.articles.revision', $article) }}" method="POST">
                @csrf
                <textarea name="notes" rows="4" required placeholder="Contoh: Tambahkan konfirmasi dari pihak narasumber OSIS dan perbaiki kalimat pembuka..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-xs leading-relaxed focus:outline-none focus:ring-2 focus:ring-rose-600 mb-4"></textarea>

                <div class="flex items-center justify-end space-x-2">
                    <button type="button" @click="revisionModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white rounded-lg shadow-sm">
                        Kirim Catatan Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
