# DESIGN SYSTEM — JURNALISTIK SPELAND
## Portal Berita Digital & Manajemen Redaksi SMP Negeri 9 Probolinggo

### 1. Brand Identity & Personality
- **Nama Publikasi**: JURNALISTIK SPELAND
- **Tagline**: Mengabarkan Fakta, Menyuarakan Cerita
- **Institusi**: SMP Negeri 9 Probolinggo
- **Karakter**: Profesional, modern, editorial, kredibel, edukatif, dan berpijak pada standar pers digital.
- **Konsep**: Koran digital modern dengan visual hierarchy yang tegas, tipografi yang nyaman dibaca, dan tata letak berbasis grid editorial.

### 2. Antislop Dials
- **ENERGY**: 3 (Editorial authority, strong headlines, crisp newsprint contrast)
- **RHYTHM**: 3 (Varied rhythm across sections: Lead Story Hero, 3-column news grid, sidebar popularity rankings, multimedia gallery carousel, opinion feature column)
- **MOTION**: 1 (Essential feedback only: subtle card hover lift, smooth modal/menu transition, no perpetual bouncing or pulsing)

### 3. Palet Warna (Color Palette)
- **Primary / Brand Navy**: `#0A2540` (Navy Tua Pers)
- **Secondary / Slate Navy**: `#1E3A8A` (Aksen Navigasi & Tag Kategori)
- **Breaking News Accent**: `#DC2626` (Merah Breaking News & Status Penting)
- **Media Link Blue**: `#2563EB` (Interaksi Tautan & Tombol Aksi)
- **Surface / Background**:
  - Main Background: `#FFFFFF` (Putih Bersih)
  - Secondary Surface: `#F8FAFC` (Abu Lembut Lembaran Kertas Berita)
  - Editorial Card Surface: `#FFFFFF`
  - Border Lines: `#E2E8F0` (Garis Pemisah Kolom Berita)
- **Typography Colors**:
  - Headline Text: `#0F172A` (Charcoal Tua Pekat, Kontras Tinggi WCAG AAA)
  - Body Text: `#334155` (Slate Gelap yang Nyaman Dibaca Lama)
  - Metadata & Timestamp: `#64748B` (Abu-abu Netral)

### 4. Tipografi (Typography)
- **Font Utama (UI & Headings)**: Plus Jakarta Sans / Inter (Modern Editorial Sans)
- **Font Isi Berita (Article Reading)**: Serif editorial atau Sans yang proporsional dengan line-height 1.75 untuk kenyamanan membaca panjang.
- **Hierarki Skala Teks**:
  - Hero Headline: 2.25rem - 3rem (36px - 48px), bold 800, leading-tight
  - Section Title: 1.5rem (24px), bold 700 dengan aksen garis bawah editorial
  - Card Title: 1.125rem - 1.25rem (18px - 20px), font-bold
  - Body Text: 1rem (16px), normal 400, leading-relaxed
  - Metadata / Tag / Byline: 0.75rem - 0.875rem (12px - 14px), font-medium

### 5. Komponen Kunci Editorial
1. **Top Bar**: Informasi waktu lokal, identitas SMPN 9 Probolinggo, tautan media sosial resmi.
2. **Main Masthead / Header**: Logo Jurnalistik SPELAND, nama portal, tagline, pencarian cepat, tombol autentikasi.
3. **Running Breaking News Ticker**: Bar merah kontras tinggi yang menampilkan berita mendesak dengan link langsung ke artikel.
4. **Editorial Lead Section**: Berita utama berukuran besar dengan gambar berkualitas, kategori, byline reporter, jam tayang, ringkasan berita, dan tombol baca lengkap.
5. **Sidebar Berita Terpopuler**: Penomoran editorial (1-5) dengan visual hierarchy yang jelas berdasarkan jumlah pembaca nyata dari PostgreSQL.
6. **Section Kategori Terpilih**: Tab dan grid berita sekolah, pendidikan, prestasi, adiwiyata, dan opini murid.
7. **Multimedia Spotlight**: Dokumentasi foto kegiatan dan video podcast jurnalistik dengan video embed.
8. **Editorial Footer**: Identitas redaksi resmi, alamat SMP Negeri 9 Probolinggo, kanal peliputan, pedoman siber, dan hak cipta dinamis.
