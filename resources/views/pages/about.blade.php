@extends('layouts.app')

@section('title', 'Tentang Kami - JURNALISTIK SPELAND')
@section('meta_description', 'Profil resmi, sejarah, dan visi misi Jurnalistik SMP Negeri 9 Probolinggo.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Tentang Kami</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-red-600 font-mono block mb-1">PROFIL & MANIFESTO</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                Tentang Jurnalistik SPELAND
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-serif italic mt-1 leading-relaxed">
                &ldquo;Mengabarkan Fakta, Menyuarakan Cerita.&rdquo;
            </p>
        </div>
    </div>

    <!-- Sejarah & Deskripsi -->
    <section class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs space-y-4 text-slate-800 text-sm sm:text-base leading-relaxed">
        <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">
            Profil Media
        </h2>
        <p>
            <strong>Jurnalistik SPELAND</strong> merupakan media informasi, komunikasi, dan publikasi digital resmi SMP Negeri 9 Probolinggo yang dikelola secara profesional dan bertanggung jawab oleh tim jurnalis pelajar sekolah.
        </p>
        <p>
            Platform ini menjadi wadah kreativitas murid dalam bidang jurnalistik, literasi digital, fotografi lapangan, videografi, penulisan berita, desain komunikasi visual, serta produksi gelar wicara multimedia.
        </p>
    </section>

    <!-- Visi dan Misi -->
    <section class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs space-y-6">
        <div>
            <h2 class="text-sm font-black text-blue-950 uppercase tracking-wider mb-2 flex items-center">
                <i data-lucide="compass" class="w-4 h-4 mr-2 text-blue-900"></i>
                Visi
            </h2>
            <p class="text-slate-800 text-sm sm:text-base leading-relaxed">
                Menjadi media publikasi digital sekolah yang profesional, kredibel, edukatif, dan inspiratif dalam mengabarkan kebaikan serta memupuk budaya literasi digital warga SMP Negeri 9 Probolinggo.
            </p>
        </div>

        <div class="border-t border-slate-100 pt-6">
            <h2 class="text-sm font-black text-blue-950 uppercase tracking-wider mb-3 flex items-center">
                <i data-lucide="target" class="w-4 h-4 mr-2 text-blue-900"></i>
                Misi
            </h2>
            <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700 list-disc list-inside">
                <li>Menjadi pusat informasi digital dan dokumentasi resmi kegiatan sekolah.</li>
                <li>Mendokumentasikan rekam jejak prestasi murid, guru, dan institusi secara objektif.</li>
                <li>Mengembangkan kompetensi menulis, riset fakta, dan etika pers ramah anak bagi murid.</li>
                <li>Menjadi ruang publikasi karya tulis, opini kritis, dan ekspresi seni budaya pelajar.</li>
                <li>Mengembangkan karakter peduli lingkungan melalui penyebarluasan program Adiwiyata.</li>
            </ul>
        </div>
    </section>

    <!-- Pembina & Pimpinan Redaksi -->
    <section class="space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <h2 class="text-xl font-bold text-slate-900">Pengelola & Pembina Redaksi</h2>
            <a href="{{ route('editorial.structure') }}" class="text-xs font-bold text-blue-900 hover:underline">
                Lihat Seluruh Struktur &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($members->flatten()->take(6) as $m)
                <div class="bg-white border border-slate-200 rounded-xl p-4 text-center shadow-2xs">
                    <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-20 h-20 rounded-full object-cover mx-auto mb-3 border-2 border-slate-100 shadow-xs">
                    <h3 class="font-bold text-sm text-slate-900">{{ $m->name }}</h3>
                    <p class="text-xs font-semibold text-blue-900 mt-0.5">{{ $m->position }}</p>
                    <span class="text-xs text-slate-400 mt-1 block">{{ $m->class_or_grade }}</span>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
