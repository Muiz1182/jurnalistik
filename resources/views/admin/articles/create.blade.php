@extends('layouts.admin')

@section('title', 'Tulis Berita Baru - Meja Redaksi')
@section('page_title', 'Tulis Naskah Berita Baru')

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
<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Main Form Column (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-5">
                
                <!-- Judul Utama -->
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Judul Berita *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required 
                           value="{{ old('title') }}" 
                           placeholder="Masukkan judul berita yang menarik dan informatif..." 
                           class="w-full bg-white border border-slate-300 rounded-lg px-4 py-2.5 text-base font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subjudul -->
                <div>
                    <label for="subtitle" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Subjudul (Lead Pendukung)
                    </label>
                    <input type="text" 
                           id="subtitle" 
                           name="subtitle" 
                           value="{{ old('subtitle') }}" 
                           placeholder="Keterangan singkat pengantar headline..." 
                           class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>

                <!-- Ringkasan Berita (Excerpt) -->
                <div>
                    <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Ringkasan / Excerpt
                    </label>
                    <textarea id="excerpt" 
                              name="excerpt" 
                              rows="3" 
                              placeholder="Ringkasan 2-3 kalimat yang tampil pada kartu berita dan media sosial..." 
                              class="w-full bg-white border border-slate-300 rounded-lg p-3 text-xs leading-relaxed text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('excerpt') }}</textarea>
                </div>

                <!-- Isi Artikel (Rich Text Editor) -->
                <div>
                    <label for="article-content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Isi Berita Lengkap *
                    </label>
                    <textarea id="article-content" name="content">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- SEO Settings Box -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-4">
                <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider flex items-center border-b border-slate-100 pb-3">
                    <i data-lucide="globe" class="w-4 h-4 mr-2 text-blue-900"></i>
                    Optimasi Mesin Pencari (SEO)
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">SEO Title</label>
                    <input type="text" name="seo_title" value="{{ old('seo_title') }}" placeholder="Otomatis menggunakan judul jika dikosongkan" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="2" placeholder="Otomatis menggunakan ringkasan jika dikosongkan..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('meta_description') }}</textarea>
                </div>
            </div>

        </div>

        <!-- Right Settings Column (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Publishing Actions Box -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
                <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Aksi Publikasi & Alur
                </h3>

                <div class="space-y-2.5">
                    <!-- Save Draft -->
                    <button type="submit" 
                            name="action" 
                            value="draft" 
                            class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold py-2.5 rounded-lg transition border border-slate-300 flex items-center justify-center">
                        <i data-lucide="save" class="w-4 h-4 mr-1.5 text-slate-500"></i>
                        <span>Simpan sebagai Draft</span>
                    </button>

                    <!-- Submit to Kadiv for Approval -->
                    <button type="submit" 
                            name="action" 
                            value="submit" 
                            class="w-full bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold py-2.5 rounded-lg transition shadow-sm flex items-center justify-center">
                        <i data-lucide="send" class="w-4 h-4 mr-1.5 text-blue-300"></i>
                        <span>Kirim Minta Persetujuan Kadiv</span>
                    </button>
                    <p class="text-3xs text-slate-400 text-center italic">
                        Naskah akan masuk ke antrean Kepala Divisi untuk ditinjau kelayakannya.
                    </p>

                    <!-- Direct Publish for Kadiv / Super Admin -->
                    @if(auth()->user()->canPublishArticles())
                        <div class="pt-3 border-t border-slate-200">
                            <label class="block text-2xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                                Jadwal Terbit (Opsional)
                            </label>
                            <input type="datetime-local" 
                                   name="scheduled_for" 
                                   class="w-full bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs text-slate-700 mb-2">
                            
                            <button type="submit" 
                                    name="action" 
                                    value="publish" 
                                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold py-2.5 rounded-lg transition shadow-sm flex items-center justify-center">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-1.5 text-emerald-200"></i>
                                <span>Setujui & Terbitkan Sekarang</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Category & Tags Box -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
                <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Kategori & Rubrik
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Kategori *</label>
                    <select name="category_id" required class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-900">
                        <option value="">Pilih Rubrik Berita</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tag / Kata Kunci (Koma)</label>
                    <input type="text" 
                           id="tags-input" 
                           placeholder="Contoh: Prestasi, Adiwiyata, OSIS" 
                           class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-800 mb-2">
                    <div id="tags-container" class="flex flex-wrap gap-1.5"></div>
                    <!-- Hidden tag values for submission -->
                    <div id="hidden-tags"></div>
                </div>
            </div>

            <!-- Featured Image Upload -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-4">
                <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Foto Utama Berita
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Gambar (Maks 3MB)</label>
                    <input type="file" 
                           name="featured_image" 
                           accept="image/*" 
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-900 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Caption / Keterangan Foto</label>
                    <input type="text" 
                           name="image_caption" 
                           value="{{ old('image_caption') }}" 
                           placeholder="Keterangan singkat isi foto..." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-xs text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Fotografer</label>
                    <input type="text" 
                           name="photographer_name" 
                           value="{{ old('photographer_name', auth()->user()->name) }}" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-xs text-slate-800">
                </div>
            </div>

            <!-- Flags & Preferences -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs space-y-3 text-xs">
                <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Pengaturan Tambahan
                </h3>

                @if(auth()->user()->isPemimpinRedaksi())
                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" name="is_breaking" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-600">
                        <span class="font-bold text-red-700">Tampilkan sebagai Breaking News</span>
                    </label>

                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" name="is_headline" value="1" class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                        <span class="font-semibold text-slate-800">Jadikan Headline Utama Beranda</span>
                    </label>

                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                        <span class="font-semibold text-slate-800">Sorotan Khusus (Featured)</span>
                    </label>
                @endif

                <label class="flex items-center space-x-2.5 cursor-pointer">
                    <input type="checkbox" name="allow_comments" value="1" checked class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                    <span class="font-semibold text-slate-800">Izinkan Komentar Pembaca</span>
                </label>
            </div>

        </div>

    </div>
</form>

<script>
    // Simple Tag Input Manager
    const tagInput = document.getElementById('tags-input');
    const tagsContainer = document.getElementById('tags-container');
    const hiddenTags = document.getElementById('hidden-tags');
    let tagsList = [];

    tagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = this.value.trim().replace(/^,+|,+$/g, '');
            if (val && !tagsList.includes(val)) {
                tagsList.push(val);
                renderTags();
            }
            this.value = '';
        }
    });

    function renderTags() {
        tagsContainer.innerHTML = '';
        hiddenTags.innerHTML = '';
        tagsList.forEach((tag, idx) => {
            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center bg-slate-100 text-slate-800 text-2xs font-bold px-2 py-1 rounded-md border border-slate-200';
            badge.innerHTML = `#${tag} <button type="button" onclick="removeTag(${idx})" class="ml-1 text-slate-400 hover:text-red-500 font-bold">&times;</button>`;
            tagsContainer.appendChild(badge);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tags[]';
            input.value = tag;
            hiddenTags.appendChild(input);
        });
    }

    window.removeTag = function(idx) {
        tagsList.splice(idx, 1);
        renderTags();
    };
</script>
@endsection
