# JURNALISTIK SPELAND
### Portal Berita Digital & Sistem Manajemen Redaksi Sekolah Resmi
**SMP Negeri 9 Probolinggo**

> *"Mengabarkan Fakta, Menyuarakan Cerita."*

---

## 1. Tentang JURNALISTIK SPELAND

**JURNALISTIK SPELAND** adalah platform pers dan media publikasi digital resmi SMP Negeri 9 Probolinggo yang dikelola langsung oleh tim jurnalis pelajar sekolah. Dibangun dengan standar editorial dan estetika media pers profesional setara portal berita nasional (seperti Jawa Pos, Kompas, dan Detik), platform ini berfungsi ganda sebagai:

1. **Portal Berita Publik**: Menghadirkan informasi terkini, liputan kegiatan sekolah, prestasi murid, galeri dokumentasi foto, siniar (podcast), video jurnalistik, serta esai dan karya literasi warga sekolah.
2. **Sistem Redaksi Digital (Digital Newsroom CMS)**: Mengatur workflow jurnalistik profesional bertingkat dari reporter menulis naskah, editor memeriksa fakta dan tata bahasa, hingga pemimpin redaksi menyetujui penerbitan secara transparan dengan riwayat revisi dan audit aktivitas lengkap.

---

## 2. Arsitektur & Teknologi

* **Backend Framework**: PHP 8.2+ & Laravel (Architecture MVC, Eloquent ORM, Gate & RBAC Middleware)
* **Database**: **PostgreSQL 18** (Driver `pgsql`, GIN Full-Text Index menggunakan kamus bahasa Indonesia `indonesian`)
* **Frontend UI**: Laravel Blade, Tailwind CSS v4 (Design System Editorial Newspaper), Lucide Icons, Alpine.js
* **Asset Bundler**: Vite
* **Rich Text Editor**: Tiptap Editor & TinyMCE integration

---

## 3. Fitur Utama

### A. Portal Berita Publik (18 Halaman Lengkap)
1. **Beranda (Homepage)**:
   - Header media berkarakter pers modern dengan logo, tanggal Hijriah & Masehi dinamis, navigasi rubrik, dan pencarian cepat.
   - Running text / Breaking News banner yang dapat dikendalikan langsung oleh redaksi.
   - Hero Headline berita utama berformat poster editorial.
   - Grid berita terbaru dengan thumbnail, metadata jurnalis, tanggal publikasi, dan counter views.
   - Sidebar artikel terpopuler berdasarkan algoritma jumlah pembaca terbanyak.
   - Rubrikasi kategori (Pendidikan, Kegiatan, Prestasi, Lingkungan, Literasi, Opini, dsb).
   - Feed multimedia (Galeri foto, video YouTube responsif, podcast audio visual).
2. **Indeks Semua Berita** (`/berita`): Daftar naskah terbit dengan pagination dan filter rubrik.
3. **Kategori Berita** (`/kategori/{slug}` & `/berita/kategori/{slug}`): Tampilan berita per kategori/rubrik.
4. **Detail Berita** (`/berita/{slug}`): Tipografi editorial yang nyaman dibaca, breadcrumb, foto utama ber-caption, nama penulis & fotografer, share button (WhatsApp, Facebook, X, Salin Tautan), tombol bookmark pembaca, dan kolom komentar pembaca terverifikasi.
5. **Berita Populer** (`/berita/populer`): Peringkat artikel paling banyak dibaca.
6. **Berita Terbaru** (`/berita/terbaru`): Arus kabar terbitan terbaru secara kronologis.
7. **Opini & Esai** (`/opini`): Wadah artikel pemikiran kritis murid, guru, dan esai sastra.
8. **Galeri Dokumentasi Foto** (`/galeri-foto` & `/galeri-foto/{slug}`): Album foto resolusi tinggi karya fotografer jurnalis sekolah.
9. **Video Jurnalistik** (`/video`): Dokumentasi liputan video sekolah terintegrasi YouTube player.
10. **Podcast SPELAND** (`/podcast`): Siniar suara murid dan wawancara tokoh inspiratif.
11. **Liputan Khusus** (`/liputan-khusus` & `/liputan-khusus/{slug}`): Dossier dan kurasi berseri untuk agenda besar sekolah (mis. Adiwiyata Mandiri).
12. **Tentang Kami** (`/tentang-kami`): Profil, visi, dan sejarah tim Jurnalistik SPELAND.
13. **Struktur Redaksi** (`/struktur-redaksi`): Susunan dewan redaksi, pembina, redaktur, dan reporter.
14. **Kontak Redaksi** (`/kontak-redaksi`): Saluran komunikasi, alamat sekolah, dan form hak jawab.
15. **Kebijakan Redaksi** (`/kebijakan-redaksi`): Etika pers sekolah dan perlindungan narasumber anak.
16. **Pedoman Pemberitaan Ramah Anak** (`/pedoman-pemberitaan`): Standar jurnalistik pelajar sesuai regulasi Dewan Pers.
17. **Pencarian Canggih** (`/cari?q=kata_kunci`): Mesin pencari bertenaga PostgreSQL Full-Text Search.
18. **Arsip Berita** (`/arsip`): Penelusuran arsip berita berdasarkan filter bulan, tahun, dan rubrik.

### B. Alur Kerja Meja Redaksi (Digital Newsroom Workflow)
Sistem menerapkan alur pers berjenjang:
```
[ Reporter / Jurnalis ]
   │
   ▼ Membuat Naskah / Simpan Draft
[ Draft ]
   │
   ▼ Submit ke Meja Editor
[ Submitted ]
   │
   ├───────────────┐
   ▼               ▼ (Jika perlu perbaikan)
[ Under Review ] ──> [ Revision Required ] ──> Diperbaiki oleh Reporter
   │
   ▼ Layak Terbit (Disetujui Editor)
[ Approved ]
   │
   ▼ Persetujuan Akhir & Jadwal oleh Pemimpin Redaksi
[ Scheduled / Published ]
   │
   ▼
Berita Tampil di Halaman Publik
```

### C. Manajemen Hak Akses Pengguna (Role-Based Access Control)
* **Super Admin**: Akses mutlak terhadap seluruh sistem, konfigurasi server, manajemen user, dan log audit.
* **Pemimpin Redaksi**: Otoritas penentu terbit naskah, penerbitan breaking news, penjadwalan, dan pembagian agenda liputan.
* **Editor / Redaktur**: Memeriksa akurasi fakta, menyunting ejaan naskah, memberi catatan revisi, dan menyetujui naskah.
* **Reporter / Jurnalis**: Menulis draft berita, mengunggah foto, dan memantau status naskah.
* **Fotografer**: Mengunggah album foto kegiatan dan mengelola kreditasi visual.
* **Pembaca / Kontributor**: Membaca artikel, menandai bookmark (`/bookmark-saya`), dan mengirim komentar.

### D. Fitur Pendukung Meja Redaksi
* **Penugasan Liputan (Editorial Assignments)**: Pemred/Editor memberikan surat tugas lapangan digital lengkap dengan brief angle, tenggat waktu (deadline), dan catatan revisi.
* **Statistik & Analisis Pembaca (Analytics)**: Grafik tren pembaca 14 hari terakhir (PostgreSQL log), distribusi rubrik, peringkat artikel terpopuler, dan metrik produktivitas jurnalis.
* **Audit Trail (Activity Log)**: Pencatatan otomatis setiap tindakan redaksi beserta IP address dan waktu kejadian.
* **Deduplikasi Pembaca**: Tracking jumlah pembaca menggunakan kombinasi IP address, User Agent, dan tanggal agar penghitungan views objektif tanpa spam reload.

---

## 4. Akun Default untuk Pengembangan

Semua akun terdaftar menggunakan kata sandi: `password123`

| Role | Username | Email | Kegunaan |
|---|---|---|---|
| **Super Admin** | `admin` | `admin@speland.sch.id` | Konfigurasi sistem, manajemen user, settings |
| **Pemimpin Redaksi** | `pemred` | `pemred@speland.sch.id` | Penugasan liputan, persetujuan akhir & penerbitan naskah |
| **Editor / Redaktur** | `editor` | `editor@speland.sch.id` | Penyuntingan teks, catatan revisi, moderasi komentar |
| **Reporter** | `reporter` | `reporter@speland.sch.id` | Pembuatan naskah liputan dan pengiriman ke editor |
| **Fotografer** | `fotografer` | `fotografer@speland.sch.id` | Manajemen album foto dokumentasi |
| **Pembaca Terdaftar** | `pembaca` | `pembaca@speland.sch.id` | Pengujian bookmark dan interaksi komentar |

---

## 5. Panduan Instalasi & Menjalankan Aplikasi

### Persyaratan Sistem
1. PHP versi 8.2 atau lebih baru dengan ekstensi `pdo_pgsql` dan `pgsql` aktif.
2. PostgreSQL versi 14 atau lebih baru (direkomendasikan PostgreSQL 18).
3. Composer.
4. Node.js (v18+) & NPM.

### Langkah Instalasi

1. **Clone repositori dan masuk ke direktori proyek**:
   ```bash
   git clone <repo-url>
   cd JURNALISTIK-SPELAND
   ```

2. **Instal dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment Database PostgreSQL**:
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan konfigurasi database di file `.env` mengarah ke PostgreSQL:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=jurnalistik_speland
   DB_USERNAME=postgres
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi Database & Seeder Data Lengkap**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Hubungkan Symlink Penyimpanan Media**:
   ```bash
   php artisan storage:link
   ```

6. **Kompilasi Aset Frontend**:
   ```bash
   npm run build
   ```

7. **Jalankan Web Server**:
   ```bash
   php artisan serve
   ```
   Buka browser pada alamat: `http://localhost:8000`

---

## 6. Pengujian Sistem (Automated Tests)

Jalankan rangkaian test otomatis dengan PHPUnit:
```bash
php artisan test
```

Semua endpoint publik, alur autentikasi, dan hak akses dashboard telah terlindungi oleh pengujian unit dan fitur otomatis.

---

## 7. Lisensi & Hak Cipta

Dikembangkan untuk **SMP Negeri 9 Probolinggo** sebagai sistem informasi jurnalistik dan literasi digital sekolah.  
Hak Cipta &copy; 2026 Jurnalistik SPELAND. Seluruh hak cipta dilindungi undang-undang.
