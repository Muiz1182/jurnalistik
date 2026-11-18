@extends('layouts.app')

@section('title', 'Kebijakan Redaksi - JURNALISTIK SPELAND')
@section('meta_description', 'Standar operasional prosedur redaksi, independensi pemberitaan, dan kode etik internal Jurnalistik SPELAND.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <div class="border-b-2 border-blue-950 pb-5">
        <span class="text-xs font-bold text-red-600 uppercase tracking-wider block">Standar Editorial</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">
            Kebijakan Redaksi
        </h1>
        <p class="text-sm text-slate-600 mt-2">
            Pedoman independensi, akurasi, keberimbangan, dan perlindungan anak dalam pemberitaan media sekolah.
        </p>
    </div>

    <div class="prose prose-slate max-w-none text-sm sm:text-base leading-relaxed space-y-6">
        <section>
            <h2 class="text-xl font-bold text-slate-900">1. Prinsip Utama Pemberitaan</h2>
            <p>
                Jurnalistik SPELAND berlandaskan pada prinsip pencarian fakta, verifikasi sumber, keberimbangan (cover both sides), dan penyajian informasi yang mendidik. Setiap laporan yang diterbitkan harus dapat dipertanggungjawabkan kebenarannya kepada publik sekolah dan masyarakat.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-900">2. Perlindungan Identitas dan Ramah Anak</h2>
            <p>
                Mengingat status sebagai media di lingkungan pendidikan menengah pertama, redaksi wajib mematuhi kaidah perlindungan anak. Redaksi tidak akan mempublikasikan identitas, foto, maupun data pribadi murid yang sedang berhadapan dengan masalah hukum, pelanggaran disiplin sensitif, maupun korban perundungan.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-900">3. Alur Verifikasi Naskah</h2>
            <p>
                Setiap berita melalui alur berjenjang: Reporter meliput dan menyusun draf berita, Editor memeriksa keakuratan data dan tata bahasa, dan Pemimpin Redaksi memberikan persetujuan akhir sebelum naskah ditayangkan di portal publik.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-900">4. Hak Jawab dan Koreksi Ralat</h2>
            <p>
                Pihak yang merasa dirugikan oleh pemberitaan berhak mengajukan Hak Jawab atau Hak Koreksi. Redaksi berkewajiban meneliti kembali fakta dan menerbitkan ralat secara transparan pada artikel terkait.
            </p>
        </section>
    </div>

</div>
@endsection
