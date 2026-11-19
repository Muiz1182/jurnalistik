@extends('layouts.app')

@section('title', 'Kontak & Kirim Naskah - JURNALISTIK SPELAND')
@section('meta_description', 'Hubungi dewan redaksi Jurnalistik SPELAND atau kirimkan siaran pers dan naskah tulisan.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Kontak & Redaksi</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-red-600 font-mono block mb-1">KOMUNIKASI & HAK JAWAB</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                Kontak Redaksi & Pengiriman Naskah
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                Saluran resmi komunikasi, kemitraan liputan, permohonan hak jawab, serta pengiriman karya opini murid SMP Negeri 9 Probolinggo.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        <!-- Info Kontak Card -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 space-y-6 shadow-2xs">
            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center">
                <i data-lucide="building" class="w-4 h-4 mr-2 text-blue-900"></i>
                Alamat Redaksi
            </h2>

            <div class="space-y-4 text-xs sm:text-sm text-slate-700">
                <div class="flex items-start">
                    <i data-lucide="map-pin" class="w-4 h-4 mr-3 shrink-0 text-blue-900 mt-0.5"></i>
                    <div>
                        <strong class="block text-slate-900">{{ \App\Models\Setting::get('school_name', 'SMP Negeri 9 Probolinggo') }}</strong>
                        <span class="text-slate-600 leading-relaxed">{{ \App\Models\Setting::get('school_address', 'Jl. Mastrip No. 123, Kanigaran, Kota Probolinggo, Jawa Timur 67213') }}</span>
                    </div>
                </div>

                <div class="flex items-center">
                    <i data-lucide="mail" class="w-4 h-4 mr-3 shrink-0 text-blue-900"></i>
                    <div>
                        <span class="block text-slate-500 text-3xs uppercase tracking-wider font-semibold">Email Redaksi:</span>
                        <a href="mailto:{{ \App\Models\Setting::get('editorial_email') }}" class="font-bold text-blue-900 hover:underline">
                            {{ \App\Models\Setting::get('editorial_email', 'redaksi.speland@gmail.com') }}
                        </a>
                    </div>
                </div>

                <div class="flex items-center">
                    <i data-lucide="phone" class="w-4 h-4 mr-3 shrink-0 text-blue-900"></i>
                    <div>
                        <span class="block text-slate-500 text-3xs uppercase tracking-wider font-semibold">Telepon Sekolah:</span>
                        <span class="font-bold text-slate-900">{{ \App\Models\Setting::get('school_phone', '(0335) 421999') }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-5">
                <h3 class="text-3xs font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Jam Operasional Meja Redaksi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Senin &ndash; Jumat: 07.00 &ndash; 15.30 WIB<br>Sabtu: 07.30 &ndash; 12.00 WIB (Sesi Ekstrakurikuler Jurnalistik)</p>
            </div>
        </div>

        <!-- Panduan Pengiriman Naskah -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3 flex items-center">
                <i data-lucide="send" class="w-5 h-5 mr-2 text-blue-900"></i>
                Panduan Kirim Naskah
            </h2>

            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Naskah berita, opini, puisi, resensi buku, maupun foto kegiatan dapat dikirimkan langsung melalui email redaksi atau diserahkan kepada perwakilan dewan redaksi di ruang multimedia.
            </p>

            <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl space-y-2 text-xs text-blue-950">
                <p class="font-bold">Ketentuan Naskah:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Karya asli (orisinil) dan belum pernah dipublikasikan di media lain.</li>
                    <li>Menyertakan identitas jelas (Nama lengkap, kelas, nomor kontak).</li>
                    <li>Format dokumen: Word (.docx) atau teks pada badan email.</li>
                    <li>Foto pendukung resolusi tinggi dengan keterangan caption yang jelas.</li>
                </ul>
            </div>
        </div>

    </div>

</div>
@endsection
