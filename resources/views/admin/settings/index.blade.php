@extends('layouts.admin')

@section('title', 'Konfigurasi Portal Berita - Meja Redaksi')
@section('page_title', 'Pengaturan Website & Kebijakan Redaksi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ tab: 'general' }">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Konfigurasi Portal & Identitas Media</h2>
            <p class="text-xs text-slate-500">Kelola informasi sekolah, identitas redaksi, media sosial, dan breaking news ticker.</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex border-b border-slate-200 space-x-4 text-xs font-bold">
        <button type="button" @click="tab = 'general'" :class="tab === 'general' ? 'border-blue-950 text-blue-950 border-b-2 py-2.5' : 'text-slate-500 hover:text-slate-800 py-2.5'">
            Identitas Media & Sekolah
        </button>
        <button type="button" @click="tab = 'breaking'" :class="tab === 'breaking' ? 'border-blue-950 text-blue-950 border-b-2 py-2.5' : 'text-slate-500 hover:text-slate-800 py-2.5'">
            Running Text / Breaking News
        </button>
        <button type="button" @click="tab = 'editorial'" :class="tab === 'editorial' ? 'border-blue-950 text-blue-950 border-b-2 py-2.5' : 'text-slate-500 hover:text-slate-800 py-2.5'">
            Pedoman & Kebijakan Redaksi
        </button>
        <button type="button" @click="tab = 'social'" :class="tab === 'social' ? 'border-blue-950 text-blue-950 border-b-2 py-2.5' : 'text-slate-500 hover:text-slate-800 py-2.5'">
            Kontak & Sosial Media
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs space-y-6">
        @csrf
        @method('PUT')

        <!-- Tab 1: Identitas Media & Sekolah -->
        <div x-show="tab === 'general'" class="space-y-5" x-data="{ logoPreview: null, removeLogo: false }">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100">Informasi Media & Satuan Pendidikan</h3>
            
            <!-- Logo Website / Lambang Portal Media -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                            Logo Website / Lambang Media
                        </label>
                        <p class="text-3xs text-slate-500 mt-0.5">
                            Logo resmi yang tampil pada header publik, sidebar redaksi, favicon, dan footer portal.
                        </p>
                    </div>
                    @if(\App\Models\Setting::get('site_logo'))
                        <span class="text-3xs font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                            Logo Kustom Aktif
                        </span>
                    @else
                        <span class="text-3xs font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-200 text-slate-700">
                            Emblem Standar JS
                        </span>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-5 pt-2">
                    <!-- Current / Live Preview Container -->
                    <div class="shrink-0 flex flex-col items-center">
                        <template x-if="logoPreview">
                            <div class="w-16 h-16 rounded-xl overflow-hidden border-2 border-blue-900 shadow-sm bg-white p-1">
                                <img :src="logoPreview" alt="Pratinjau Logo" class="w-full h-full object-contain">
                            </div>
                        </template>
                        <template x-if="!logoPreview">
                            <div>
                                @if(\App\Models\Setting::get('site_logo'))
                                    <div class="w-16 h-16 rounded-xl overflow-hidden border border-slate-300 shadow-sm bg-white p-1">
                                        <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo Saat Ini" class="w-full h-full object-contain">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-slate-950 text-white flex flex-col items-center justify-center border-b-2 border-red-600 shadow-sm">
                                        <span class="font-serif font-black text-2xl leading-none">JS</span>
                                        <span class="text-3xs font-extrabold uppercase tracking-widest text-red-400 scale-75 -mt-0.5">PRESS</span>
                                    </div>
                                @endif
                            </div>
                        </template>
                        <span class="text-3xs text-slate-400 font-semibold mt-1.5" x-text="logoPreview ? 'Pratinjau Baru' : 'Logo Aktif'"></span>
                    </div>

                    <!-- Upload Input Controls -->
                    <div class="flex-1 space-y-3">
                        <div>
                            <input type="file" 
                                   name="site_logo" 
                                   id="site_logo" 
                                   accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { logoPreview = e.target.result; removeLogo = false; }; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-950 file:text-white hover:file:bg-blue-900 cursor-pointer bg-white border border-slate-200 rounded-lg p-1">
                            @error('site_logo')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-2 text-2xs text-slate-500">
                            <span>Format didukung: <strong>PNG, JPG, WEBP, SVG</strong> (Maks. 2 MB). Disarankan rasio 1:1.</span>
                            
                            @if(\App\Models\Setting::get('site_logo'))
                                <label class="inline-flex items-center text-red-600 hover:text-red-700 cursor-pointer font-bold">
                                    <input type="checkbox" name="remove_logo" value="1" x-model="removeLogo" @change="if(removeLogo) { logoPreview = null; document.getElementById('site_logo').value = ''; }" class="w-3.5 h-3.5 rounded text-red-600 focus:ring-red-500 mr-1.5">
                                    <span>Hapus logo kustom (Gunakan lambang JS default)</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Portal Media *</label>
                    <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'JURNALISTIK SPELAND') }}" required class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tagline Resmi *</label>
                    <input type="text" name="site_tagline" value="{{ \App\Models\Setting::get('site_tagline', 'Mengabarkan Fakta, Menyuarakan Cerita.') }}" required class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Sekolah *</label>
                    <input type="text" name="school_name" value="{{ \App\Models\Setting::get('school_name', 'SMP Negeri 9 Probolinggo') }}" required class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kepala Sekolah / Pembina</label>
                    <input type="text" name="advisor_name" value="{{ \App\Models\Setting::get('advisor_name', 'Drs. H. Bambang Wahyudi, M.Pd.') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Lengkap Sekolah</label>
                <input type="text" name="school_address" value="{{ \App\Models\Setting::get('school_address', 'Jl. Mastrip No. 123, Kanigaran, Kota Probolinggo, Jawa Timur 67213') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat Portal (Tentang Kami)</label>
                <textarea name="about_brief" rows="3" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">{{ \App\Models\Setting::get('about_brief') }}</textarea>
            </div>
        </div>

        <!-- Tab 2: Breaking News -->
        <div x-show="tab === 'breaking'" class="space-y-4">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100">Pengaturan Ticker / Breaking News</h3>
            
            <div class="flex items-center space-x-3 bg-amber-50 p-3 rounded-lg border border-amber-200/60">
                <input type="hidden" name="breaking_news_active" value="0">
                <input type="checkbox" name="breaking_news_active" id="breaking_news_active" value="1" {{ \App\Models\Setting::get('breaking_news_active') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-950 focus:ring-blue-950">
                <label for="breaking_news_active" class="text-xs font-bold text-slate-800 cursor-pointer">
                    Aktifkan Breaking News Ticker di bagian atas halaman beranda
                </label>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Teks Berita Penting / Flash</label>
                <input type="text" name="breaking_news_text" value="{{ \App\Models\Setting::get('breaking_news_text') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Contoh: SMPN 9 Probolinggo Raih Juara 1 Tingkat Kota...">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tautan / Link Berita Tujuan</label>
                <input type="text" name="breaking_news_url" value="{{ \App\Models\Setting::get('breaking_news_url') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="/berita/judul-berita">
            </div>
        </div>

        <!-- Tab 3: Kebijakan Redaksi -->
        <div x-show="tab === 'editorial'" class="space-y-4">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100">Pedoman & Etika Redaksi</h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Pemimpin Redaksi Saat Ini</label>
                <input type="text" name="chief_editor" value="{{ \App\Models\Setting::get('chief_editor', 'Ahmad Fauzi') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kebijakan Editorial & Pedoman Hak Jawab</label>
                <textarea name="editorial_policy" rows="6" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 leading-relaxed">{{ \App\Models\Setting::get('editorial_policy') }}</textarea>
            </div>
        </div>

        <!-- Tab 4: Kontak & Medsos -->
        <div x-show="tab === 'social'" class="space-y-4">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100">Kontak Resmi & Media Sosial</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Redaksi</label>
                    <input type="email" name="editorial_email" value="{{ \App\Models\Setting::get('editorial_email') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Sekolah</label>
                    <input type="email" name="school_email" value="{{ \App\Models\Setting::get('school_email') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Telepon Sekolah / Redaksi</label>
                    <input type="text" name="school_phone" value="{{ \App\Models\Setting::get('school_phone') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Instagram Resmi</label>
                    <input type="url" name="social_instagram" value="{{ \App\Models\Setting::get('social_instagram') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kanal YouTube Resmi</label>
                    <input type="url" name="social_youtube" value="{{ \App\Models\Setting::get('social_youtube') }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://youtube.com/@smpnegeri9probolinggo">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Akun TikTok Resmi</label>
                    <input type="url" name="social_tiktok" value="{{ \App\Models\Setting::get('social_tiktok', \App\Models\Setting::get('social_facebook')) }}" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://www.tiktok.com/@smpnegeri9probolinggo">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold rounded-lg shadow-2xs transition">
                Simpan Konfigurasi
            </button>
        </div>
    </form>

</div>
@endsection
