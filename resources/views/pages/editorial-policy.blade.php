@extends('layouts.app')

@section('title', 'Kebijakan Redaksi - JURNALISTIK SPELAND')
@section('meta_description', 'Standar operasional prosedur redaksi, independensi pemberitaan, dan kode etik internal Jurnalistik SPELAND.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition flex items-center">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-900 font-semibold">Kebijakan Redaksi</span>
        </nav>

        <div class="pt-1 border-t border-slate-100">
            <span class="text-3xs uppercase tracking-widest font-black text-amber-600 font-mono block mb-1">STANDAR & ETIKA PERS</span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-slate-950 tracking-tight">
                Kebijakan Redaksi
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                Pedoman independensi, akurasi fakta, keberimbangan liputan, dan perlindungan privasi anak dalam pemberitaan media sekolah.
            </p>
        </div>
    </div>

    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-2xs prose prose-slate max-w-none text-sm sm:text-base leading-relaxed space-y-6">
        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">1. Prinsip Utama Pemberitaan</h2>
            <p>
                Jurnalistik SPELAND berlandaskan pada prinsip pencarian fakta, verifikasi sumber, keberimbangan (cover both sides), dan penyajian informasi yang mendidik. Setiap laporan yang diterbitkan harus dapat dipertanggungjawabkan kebenarannya kepada publik sekolah dan masyarakat.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">2. Perlindungan Identitas dan Ramah Anak</h2>
            <p>
                Mengingat status sebagai media di lingkungan pendidikan menengah pertama, redaksi wajib mematuhi kaidah perlindungan anak. Redaksi tidak akan mempublikasikan identitas, foto, maupun data pribadi murid yang sedang berhadapan dengan masalah hukum, pelanggaran disiplin sensitif, maupun korban perundungan.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">3. Alur Verifikasi Naskah</h2>
            <p>
                Setiap berita melalui alur berjenjang: Reporter meliput dan menyusun draf berita, Editor memeriksa keakuratan data dan tata bahasa, dan Pemimpin Redaksi memberikan persetujuan akhir sebelum naskah ditayangkan di portal publik.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 border-l-3 border-blue-900 pl-3">4. Hak Jawab dan Koreksi Ralat</h2>
            <p>
                Pihak yang merasa dirugikan oleh pemberitaan berhak mengajukan Hak Jawab atau Hak Koreksi. Redaksi berkewajiban meneliti kembali fakta dan menerbitkan ralat secara transparan pada artikel terkait.
            </p>
        </section>
    </div>

</div>
@endsection
