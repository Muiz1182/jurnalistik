@extends('layouts.app')

@section('title', 'Pedoman Pemberitaan Media Siber - JURNALISTIK SPELAND')
@section('meta_description', 'Penerapan Pedoman Pemberitaan Media Siber dan etika pers digital pada portal Jurnalistik SPELAND.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Pedoman Media Siber</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-pink-600 font-mono block mb-1">REGULASI PERS DIGITAL</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                Pedoman Pemberitaan Media Siber
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                Standar etika pengelolaan konten siber, moderasi komentar pengguna, dan klarifikasi ralat berita digital ramah anak.
            </p>
        </div>
    </div>

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs prose prose-slate max-w-none text-sm sm:text-base leading-relaxed space-y-6">
        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">1. Ruang Lingkup</h2>
            <p>
                Pedoman ini berlaku untuk seluruh karya jurnalistik yang dipublikasikan pada portal digital Jurnalistik SPELAND (teks, foto, audio, video, dan infografis).
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">2. Verifikasi dan Keberimbangan Berita</h2>
            <p>
                Setiap berita wajib melalui proses verifikasi fakta sebelum ditayangkan. Berita yang memuat sangkaan atau konflik wajib menyertakan klarifikasi dari pihak-pihak terkait secara seimbang.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">3. Isi Buatan Pengguna (User Generated Content)</h2>
            <p>
                Komentar pembaca dan kiriman karya opini dikategorikan sebagai konten buatan pengguna. Redaksi menerapkan sistem pra-moderasi (moderasi sebelum tayang) untuk mencegah masuknya ujaran kebencian, fitnah, pornografi, dan konten SARA.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">4. Pencabutan dan Ralat Berita</h2>
            <p>
                Berita yang telah dipublikasikan tidak dapat dicabut sembarangan, kecuali menyangkut privasi keselamatan anak atau perintah hukum yang sah. Ralat dilakukan dengan menyematkan catatan ralat di bagian bawah naskah berita tanpa menghapus jejak koreksi.
            </p>
        </section>
    </div>

</div>
@endsection
