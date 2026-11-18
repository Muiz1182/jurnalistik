<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\EditorialMember;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Permission;
use App\Models\Podcast;
use App\Models\Role;
use App\Models\Setting;
use App\Models\SpecialCoverage;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $rolesData = [
            ['name' => 'Super Administrator', 'slug' => 'super-admin', 'description' => 'Akses penuh seluruh sistem dan konfigurasi'],
            ['name' => 'Pemimpin Redaksi', 'slug' => 'pemimpin-redaksi', 'description' => 'Penanggung jawab redaksi, persetujuan akhir penerbitan berita'],
            ['name' => 'Editor', 'slug' => 'editor', 'description' => 'Pemeriksa naskah, penyunting berita, dan kurator konten'],
            ['name' => 'Reporter / Jurnalis', 'slug' => 'reporter', 'description' => 'Penulis berita, peliput kegiatan, dan pembuat draft'],
            ['name' => 'Fotografer', 'slug' => 'fotografer', 'description' => 'Pengunggah dokumentasi visual, galeri, dan caption'],
            ['name' => 'Pembaca', 'slug' => 'pembaca', 'description' => 'Pengguna umum terdaftar untuk bookmark dan komentar'],
        ];

        $roles = [];
        foreach ($rolesData as $r) {
            $roles[$r['slug']] = Role::create($r);
        }

        // 2. Initial Categories (10 standard categories as requested)
        $categoriesData = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'color' => '#0F2C59', 'order' => 1, 'description' => 'Kabar kurikulum, metode pembelajaran, dan penguatan kompetensi murid'],
            ['name' => 'Sekolah', 'slug' => 'sekolah', 'color' => '#1E3A8A', 'order' => 2, 'description' => 'Kabar internal, sarana prasarana, dan dinamika SMPN 9 Probolinggo'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'color' => '#B45309', 'order' => 3, 'description' => 'Pencapaian akademik, olahraga, dan seni murid serta guru'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'color' => '#047857', 'order' => 4, 'description' => 'Dokumentasi agenda, peringatan hari besar, dan kepramukaan'],
            ['name' => 'Lingkungan', 'slug' => 'lingkungan', 'color' => '#15803D', 'order' => 5, 'description' => 'Gerakan Adiwiyata, kelestarian alam, dan pemilahan sampah sekolah'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'color' => '#4338CA', 'order' => 6, 'description' => 'Literasi digital, pemanfaatan laboratorium komputer, dan inovasi sains'],
            ['name' => 'Organisasi', 'slug' => 'organisasi', 'color' => '#6D28D9', 'order' => 7, 'description' => 'Kiprah OSIS, Pramuka, PMR, Paskibra, dan ekstrakurikuler sekolah'],
            ['name' => 'Literasi', 'slug' => 'literasi', 'color' => '#BE185D', 'order' => 8, 'description' => 'Gerakan membaca, resensi buku perpustakaan, dan karya puisi murid'],
            ['name' => 'Opini', 'slug' => 'opini', 'color' => '#C2410C', 'order' => 9, 'description' => 'Sudut pandang murid, gagasan kritis guru, dan esai pendidikan'],
            ['name' => 'Informasi Sekolah', 'slug' => 'informasi-sekolah', 'color' => '#334155', 'order' => 10, 'description' => 'Pengumuman resmi kedinasan, jadwal akademik, dan agenda resmi'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::create($c);
        }

        // 3. Editorial Team Users (Development Credentials)
        $superAdmin = User::create([
            'name' => 'Admin Utama SPELAND',
            'username' => 'admin',
            'email' => 'admin@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['super-admin']->id,
            'title' => 'Koordinator Sistem Informasi',
            'bio' => 'Pengelola sistem digital dan infrastruktur media SMP Negeri 9 Probolinggo.',
            'status' => 'active',
        ]);

        $pemred = User::create([
            'name' => 'Ahmad Fauzi',
            'username' => 'pemred',
            'email' => 'pemred@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['pemimpin-redaksi']->id,
            'title' => 'Pemimpin Redaksi',
            'bio' => 'Pemimpin Redaksi Jurnalistik SPELAND periode 2026/2027.',
            'status' => 'active',
        ]);

        $editor = User::create([
            'name' => 'Siti Rahmawati',
            'username' => 'editor',
            'email' => 'editor@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['editor']->id,
            'title' => 'Redaktur Berita',
            'bio' => 'Editor naskah berita kegiatan dan artikel opini murid.',
            'status' => 'active',
        ]);

        $reporter = User::create([
            'name' => 'Rizky Pratama',
            'username' => 'reporter',
            'email' => 'reporter@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['reporter']->id,
            'title' => 'Reporter Utama',
            'bio' => 'Jurnalis muda peliput kegiatan kesiswaan dan kejuaraan sekolah.',
            'status' => 'active',
        ]);

        $fotografer = User::create([
            'name' => 'Dinda Permata',
            'username' => 'fotografer',
            'email' => 'fotografer@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['fotografer']->id,
            'title' => 'Fotografer Jurnalistik',
            'bio' => 'Pencinta fotografi jurnalistik dan visual storytelling sekolah.',
            'status' => 'active',
        ]);

        $pembaca = User::create([
            'name' => 'Budi Santoso',
            'username' => 'pembaca',
            'email' => 'pembaca@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['pembaca']->id,
            'title' => 'Alumni & Pembaca Setia',
            'bio' => 'Pemerhati karya jurnalistik pelajar Kota Probolinggo.',
            'status' => 'active',
        ]);

        // 4. Tags
        $tagsData = ['Adiwiyata', 'OSIS', 'Olimpiade', 'Pramuka', 'LiterasiSekolah', 'KotaProbolinggo', 'KaryaMurid', 'P5KurikulumMerdeka', 'KantinSehat', 'SeniBudaya'];
        $tags = [];
        foreach ($tagsData as $t) {
            $tags[$t] = Tag::create(['name' => $t, 'slug' => Str::slug($t)]);
        }

        // 5. System Settings
        $settings = [
            'site_name' => 'JURNALISTIK SPELAND',
            'site_tagline' => 'Mengabarkan Fakta, Menyuarakan Cerita.',
            'school_name' => 'SMP Negeri 9 Probolinggo',
            'school_address' => 'Jl. Mastrip No. 123, Kanigaran, Kota Probolinggo, Jawa Timur 67213',
            'school_phone' => '(0335) 421999',
            'school_email' => 'smpn9probolinggo@gmail.com',
            'editorial_email' => 'redaksi.speland@gmail.com',
            'social_instagram' => 'https://instagram.com/smpn9probolinggo_official',
            'social_youtube' => 'https://youtube.com/@smpnegeri9probolinggo',
            'social_facebook' => 'https://facebook.com/smpnegeri9probolinggo',
            'chief_editor' => 'Ahmad Fauzi',
            'advisor_name' => 'Drs. H. Bambang Wahyudi, M.Pd.',
            'about_brief' => 'Jurnalistik SPELAND merupakan media informasi, komunikasi, dan publikasi digital resmi SMP Negeri 9 Probolinggo yang dikelola langsung oleh tim jurnalis pelajar sekolah.',
            'editorial_policy' => 'Redaksi Jurnalistik SPELAND menjunjung tinggi independensi fakta, etika pemberitaan ramah anak, ketepatan verifikasi, dan keberpihakan pada nilai-nilai pendidikan karakter.',
            'breaking_news_active' => '1',
            'breaking_news_text' => 'SMPN 9 Probolinggo Raih Juara 1 Lomba Inovasi Sekolah Hijau Tingkat Kota Tahun 2026',
            'breaking_news_url' => '/berita/smpn-9-probolinggo-raih-juara-1-lomba-inovasi-sekolah-hijau',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 6. Editorial Members Structure (Struktur Redaksi Resmi)
        $members = [
            ['name' => 'Drs. H. Bambang Wahyudi, M.Pd.', 'position' => 'Kepala Sekolah & Pembina Utama', 'division' => 'Pembina', 'class_or_grade' => 'Kepala Sekolah', 'order' => 1],
            ['name' => 'Endang Sulistyo, S.Pd.', 'position' => 'Pembina Teknis Jurnalistik', 'division' => 'Pembina', 'class_or_grade' => 'Guru Bahasa Indonesia', 'order' => 2],
            ['name' => 'Ahmad Fauzi', 'position' => 'Pemimpin Redaksi', 'division' => 'Pimpinan', 'class_or_grade' => 'Kelas 9A', 'order' => 3],
            ['name' => 'Nadia Salsabila', 'position' => 'Wakil Pemimpin Redaksi', 'division' => 'Pimpinan', 'class_or_grade' => 'Kelas 9B', 'order' => 4],
            ['name' => 'Siti Rahmawati', 'position' => 'Redaktur Berita & Bahasa', 'division' => 'Dewan Redaksi', 'class_or_grade' => 'Kelas 9C', 'order' => 5],
            ['name' => 'Rizky Pratama', 'position' => 'Koordinator Liputan & Reporter', 'division' => 'Reporter', 'class_or_grade' => 'Kelas 8B', 'order' => 6],
            ['name' => 'Zahra Anindya', 'position' => 'Reporter Pendidikan & Opini', 'division' => 'Reporter', 'class_or_grade' => 'Kelas 8C', 'order' => 7],
            ['name' => 'Dinda Permata', 'position' => 'Kepala Divisi Fotografi', 'division' => 'Multimedia', 'class_or_grade' => 'Kelas 8A', 'order' => 8],
            ['name' => 'Muhammad Ilham', 'position' => 'Videografer & Produser Podcast', 'division' => 'Multimedia', 'class_or_grade' => 'Kelas 9D', 'order' => 9],
        ];

        foreach ($members as $m) {
            EditorialMember::create($m);
        }

        // 7. Realistic Sample Articles (Published, High-Quality Editorial Copy)
        $articles = [
            [
                'title' => 'SMPN 9 Probolinggo Raih Juara 1 Lomba Inovasi Sekolah Hijau Tingkat Kota',
                'slug' => 'smpn-9-probolinggo-raih-juara-1-lomba-inovasi-sekolah-hijau',
                'subtitle' => 'Pemanfaatan biopori digital dan komposter mandiri antarkan SPELAND raih penghargaan bergengsi Dinas Lingkungan Hidup.',
                'excerpt' => 'Tim Adiwiyata SMP Negeri 9 Probolinggo sukses menorehkan prestasi gemilang dengan menyabet juara pertama dalam Lomba Inovasi Sekolah Hijau se-Kota Probolinggo.',
                'content' => '<p><strong>PROBOLINGGO</strong> — Semangat pelestarian lingkungan yang konsisten ditanamkan di SMP Negeri 9 Probolinggo berbuah manis. Pada ajang penganugerahan Lomba Inovasi Sekolah Hijau yang diselenggarakan Dinas Lingkungan Hidup (DLH) Kota Probolinggo, tim Adiwiyata SPELAND dinobatkan sebagai Juara Pertama kategori SMP/MTs se-Kota Probolinggo.</p><p>Penghargaan tersebut diserahkan langsung oleh Kepala Dinas Lingkungan Hidup di Gedung Kesenian Kota Probolinggo, disaksikan perwakilan puluhan sekolah dari berbagai jenjang.</p><h3>Inovasi Biopori Mandiri dan Manajemen Kompos Organik</h3><p>Kepala SMP Negeri 9 Probolinggo, Drs. H. Bambang Wahyudi, M.Pd., menyampaikan bahwa keberhasilan ini merupakan buah kerja keras seluruh warga sekolah. Mulai dari murid, dewan guru, hingga staf tata usaha terlibat aktif dalam program harian pemilahan sampah organik dan anorganik.</p><p>"Kunci utama penilaian dewan juri terletak pada keberlanjutan program. Kami tidak hanya membuat lubang biopori saat ada lomba, tetapi menjadikannya sebagai sarana edukasi sains terpadu bagi murid kelas 7 hingga kelas 9," terang beliau saat ditemui redaksi di ruang kerjanya.</p><p>Selain itu, sistem komposter anaerob yang dikembangkan kelompok ekstrakurikuler Karya Ilmiah Remaja (KIR) berhasil menghasilkan pupuk cair yang langsung dimanfaatkan untuk menyuburkan kebun hidroponik sekolah di sayap barat gedung utama.</p><h3>Apresiasi dan Rencana Menuju Adiwiyata Mandiri</h3><p>Koordinator tim Adiwiyata sekolah, Ibu Endang Sulistyo, menambahkan bahwa kemenangan ini menjadi batu loncatan penting dalam persiapan verifikasi Adiwiyata Mandiri tingkat nasional pada tahun depan.</p><p>"Murid-murid kami membuktikan bahwa kepedulian pada bumi dapat dimulai dari hal sederhana, seperti membawa tumbler pribadi dan memilah daun kering setiap pagi sebelum bel masuk berbunyi," tutupnya penuh rasa bangga.</p>',
                'category_id' => $categories['prestasi']->id,
                'user_id' => $reporter->id,
                'editor_id' => $editor->id,
                'photographer_name' => 'Dinda Permata',
                'featured_image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'Perwakilan kader Adiwiyata SMPN 9 Probolinggo saat menerima piala kejuaraan di Gedung Kesenian Kota Probolinggo.',
                'status' => 'published',
                'published_at' => now()->subHours(3),
                'is_breaking' => true,
                'is_headline' => true,
                'is_featured' => true,
                'views_count' => 1420,
                'seo_title' => 'Juara 1 Lomba Inovasi Sekolah Hijau - Jurnalistik SPELAND',
                'meta_description' => 'Kemenangan SMP Negeri 9 Probolinggo pada ajang Sekolah Hijau DLH Kota Probolinggo tahun 2026.',
                'tags' => ['Prestasi', 'Adiwiyata', 'KotaProbolinggo'],
            ],
            [
                'title' => 'Pameran Karya P5 Angkat Kearifan Lokal dan Olahan Mangga Probolinggo',
                'slug' => 'pameran-karya-p5-angkat-kearifan-lokal-olahan-mangga',
                'subtitle' => 'Murid kelas 7 dan 8 tunjukkan kreativitas wirausaha lewat puluhan produk olahan pangan lokal.',
                'excerpt' => 'Lapangan basket SMPN 9 Probolinggo disulap menjadi pasar kreatif bernuansa budaya lokal dalam gelar karya Projek Penguatan Profil Pelajar Pancasila (P5).',
                'content' => '<p><strong>PROBOLINGGO</strong> — Gelar Karya Projek Penguatan Profil Pelajar Pancasila (P5) semester genap di SMP Negeri 9 Probolinggo berlangsung semarak. Mengusung tema besar "Kearifan Lokal dan Kewirausahaan", para murid memamerkan inovasi olahan buah mangga yang menjadi ikon kebanggaan Kota Probolinggo.</p><p>Acara yang dibuka sejak pukul 08.00 WIB ini dihadiri oleh para wali murid, pengawas pembina dinas pendidikan, serta perwakilan sekolah mitra di gugus Kanigaran.</p><h3>Dari Dodol Hingga Sabun Beraroma Mangga Arumanis</h3><p>Kreativitas murid tampak dari ragam produk yang disajikan pada setiap stan kelas. Tidak hanya makanan olahan seperti puding mangga lapis, keripik, dan selai rendah gula, stan kelas 8B bahkan memperkenalkan produk sabun ramah lingkungan berbahan dasar ekstrak kulit mangga.</p><p>"Awalnya kami membaca jurnal tentang kandungan antioksidan pada kulit mangga. Dibimbing guru IPA, kami mencoba mengekstraknya menjadi sabun cuci tangan alami," ungkap Nabila, ketua kelompok stan kelas 8B.</p><p>Gelar karya ini tidak sekadar pameran, namun juga melatih kecakapan murid dalam menyusun laporan keuangan sederhana, presentasi produk kepada konsumen, serta kerja sama tim lintas minat.</p>',
                'category_id' => $categories['kegiatan']->id,
                'user_id' => $reporter->id,
                'editor_id' => $editor->id,
                'photographer_name' => 'Muhammad Ilham',
                'featured_image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'Suasana stan pameran kewirausahaan murid SMPN 9 Probolinggo di lapangan sekolah.',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'is_breaking' => false,
                'is_headline' => false,
                'is_featured' => true,
                'views_count' => 985,
                'seo_title' => 'Gelar Karya P5 Olahan Mangga SMPN 9 Probolinggo',
                'meta_description' => 'Dokumentasi kegiatan pameran P5 SMPN 9 Probolinggo tema kearifan lokal buah mangga.',
                'tags' => ['P5KurikulumMerdeka', 'Kegiatan', 'KaryaMurid'],
            ],
            [
                'title' => 'Memupuk Budaya Berpikir Kritis Lewat Pojok Baca Kelas yang Berdaya',
                'slug' => 'memupuk-budaya-berpikir-kritis-lewat-pojok-baca-kelas',
                'subtitle' => 'Catatan editorial mengenai urgensi menghidupkan kembali minat baca mendalam di era arus informasi serba cepat.',
                'excerpt' => 'Literasi sejati bukan sekadar kemampuan merangkai huruf, melainkan keberanian menyaring informasi dan merumuskan gagasan yang bertanggung jawab.',
                'content' => '<p>Arus digitalisasi membawa kemudahan akses informasi yang belum pernah terjadi pada generasi sebelumnya. Namun, di balik limpahan data di layar gawai pintar, terdapat tantangan nyata yang dihadapi para pelajar: menurunnya daya konsentrasi membaca teks mendalam (deep reading).</p><p>Di SMP Negeri 9 Probolinggo, ikhtiar menjawab tantangan tersebut diwujudkan secara nyata melalui revitalisasi Pojok Baca di setiap ruang kelas. Bukan sekadar menumpuk buku cerita usang di sudut ruangan, pojok baca kini diintegrasikan dengan jurnal refleksi harian.</p><h3>Ruang Dialog dan Berbagi Sudut Pandang</h3><p>Setiap pagi selama 15 menit sebelum kegiatan belajar mengajar dimulai, keheningan membaca merayap di setiap lorong sekolah. Yang menarik, murid tidak dituntut menghafal isi buku, melainkan diminta menuliskan satu pertanyaan kritis atas apa yang mereka baca.</p><p>"Pertanyaan yang baik mencerminkan pikiran yang aktif," tutur Ibu Endang Sulistyo saat sesi bedah buku perpustakaan.</p><p>Ketika seorang anak terbiasa mempertanyakan argumen dalam buku secara sehat, mereka sedang membangun benteng pertahanan paling kokoh dalam menangkal disinformasi dan hoaks di media sosial.</p>',
                'category_id' => $categories['opini']->id,
                'user_id' => $pemred->id,
                'editor_id' => $editor->id,
                'photographer_name' => 'Tim Dokumentasi',
                'featured_image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'Aktivitas literasi murid membaca buku di perpustakaan digital SMPN 9 Probolinggo.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'is_breaking' => false,
                'is_headline' => false,
                'is_featured' => true,
                'views_count' => 740,
                'seo_title' => 'Opini Redaksi: Pojok Baca dan Budaya Kritis Murid',
                'meta_description' => 'Refleksi literasi editorial Jurnalistik SPELAND tentang budaya membaca mendalam di sekolah.',
                'tags' => ['LiterasiSekolah', 'Opini', 'KaryaMurid'],
            ],
            [
                'title' => 'Laboratorium Komputer SPELAND Ditingkatkan untuk Asesmen Berbasis Komputer',
                'slug' => 'laboratorium-komputer-speland-ditingkatkan-untuk-asesmen-berbasis-komputer',
                'subtitle' => 'Penambahan unit komputer berspesifikasi tinggi dan bandwidth jaringan internet berkecepatan 100 Mbps.',
                'excerpt' => 'Menjelang pelaksanaan asesmen sumatif akhir semester, pihak sekolah menyelesaikan pembaruan total infrastruktur laboratorium komputer.',
                'content' => '<p><strong>PROBOLINGGO</strong> — SMP Negeri 9 Probolinggo terus berbenah dalam melengkapi sarana teknologi pendidikan. Minggu ini, proses peremajaan 40 unit komputer di Laboratorium IT 1 dan penataan jaringan kabel serat optik berkecepatan 100 Mbps telah rampung dikerjakan.</p><p>Langkah ini memastikan kesiapan seluruh perangkat menjelang pelaksanaan asesmen berbasis komputer yang akan digelar secara serentak bulan depan.</p><p>Koordinator IT Sekolah, Bapak Danang Wicaksono, S.Kom., menjelaskan bahwa peningkatan ini tidak hanya bertujuan memperlancar ujian, namun juga memfasilitasi pembelajaran coding dasar, desain grafis digital, dan pelatihan jurnalisme multimedia bagi anggota redaksi SPELAND.</p>',
                'category_id' => $categories['teknologi']->id,
                'user_id' => $reporter->id,
                'editor_id' => $editor->id,
                'photographer_name' => 'Dinda Permata',
                'featured_image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'Suasana laboratorium komputer SMPN 9 Probolinggo yang telah diperbarui teknologinya.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'is_breaking' => false,
                'is_headline' => false,
                'is_featured' => false,
                'views_count' => 610,
                'seo_title' => 'Peremajaan Laboratorium Komputer SMPN 9 Probolinggo',
                'meta_description' => 'Fasilitas komputer baru siap mendukung ujian dan keterampilan teknologi murid.',
                'tags' => ['Teknologi', 'Sekolah'],
            ],
            [
                'title' => 'Regu Pramuka Rajawali dan Melati Raih Predikat Tergiat Lomba Tingkat II',
                'slug' => 'regu-pramuka-rajawali-dan-melati-raih-predikat-tergiat',
                'subtitle' => 'Kekompakan pionering dan ketepatan navigasi peta pita membawa piala bergilir kembali ke pangkalan SPELAND.',
                'excerpt' => 'Pangkalan SMPN 9 Probolinggo mengukuhkan dominasinya di ajang kepramukaan Lomba Tingkat II Kwartir Ranting Kanigaran.',
                'content' => '<p><strong>PROBOLINGGO</strong> — Kebanggaan kembali menyelimuti Gugus Depan pangkalan SMP Negeri 9 Probolinggo. Dua regu andalan, Regu Rajawali (Putra) dan Regu Melati (Putri), berhasil menyabet predikat Regu Tergiat I dalam perkemahan Lomba Tingkat II (LT-II) yang digelar di Bumi Perkemahan Ronggojalu.</p><p>Selama tiga hari pelaksanaan, para penggalang diuji dalam berbagai keterampilan lapangan, mulai dari pendirian tenda darurat, pionering menara pandang, sandi morse, hingga penjelajahan kompas.</p>',
                'category_id' => $categories['organisasi']->id,
                'user_id' => $reporter->id,
                'editor_id' => $editor->id,
                'photographer_name' => 'Dinda Permata',
                'featured_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'Anggota Pramuka Penggalang SMPN 9 Probolinggo merayakan keberhasilan di penutupan perkemahan.',
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'is_breaking' => false,
                'is_headline' => false,
                'is_featured' => false,
                'views_count' => 830,
                'seo_title' => 'Pramuka SPELAND Juara Tergiat LT-II Kanigaran',
                'meta_description' => 'Kemenangan regu penggalang SMP Negeri 9 Probolinggo pada ajang kepramukaan tingkat kwarran.',
                'tags' => ['Pramuka', 'Prestasi', 'Organisasi'],
            ],
            [
                'title' => 'Sosialisasi Program Kantin Sehat: Bebas Pengawet dan Wajib Wadah Pakai Ulang',
                'slug' => 'sosialisasi-program-kantin-sehat-bebas-pengawet-wadah-pakai-ulang',
                'subtitle' => 'Dukungan penuh pengelola stan kantin wujudkan lingkungan sekolah ramah gizi dan minim sampah plastik.',
                'excerpt' => 'Pihak sekolah bersama Puskesmas Kanigaran menggelar sosialisasi standar higiene sanitasi makanan bagi seluruh pengelola kantin sekolah.',
                'content' => '<p><strong>PROBOLINGGO</strong> — Menjaga kesehatan pencernaan dan asupan nutrisi murid menjadi prioritas penting di SMP Negeri 9 Probolinggo. Dalam lokakarya rutin bersama tim gizi Puskesmas Kanigaran, seluruh mitra penyedia makanan di kantin sekolah menyepakati pakta integritas Kantin Sehat Bebas Bahan Berbahaya.</p><p>Kesepakatan ini mencakup larangan penggunaan pewarna tekstil, penyedap rasa berlebih, serta komitmen tidak lagi menyajikan makanan dalam kemasan plastik sekali pakai.</p>',
                'category_id' => $categories['lingkungan']->id,
                'user_id' => $reporter->id,
                'editor_id' => $editor->id,
                'photographer_name' => 'Muhammad Ilham',
                'featured_image' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'Pemeriksaan sampel makanan kantin sekolah oleh petugas gizi dan tim Adiwiyata.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'is_breaking' => false,
                'is_headline' => false,
                'is_featured' => false,
                'views_count' => 520,
                'seo_title' => 'Kantin Sehat Ramah Lingkungan SMPN 9 Probolinggo',
                'meta_description' => 'Standarisasi makanan sehat dan bebas plastik sekali pakai di kantin sekolah.',
                'tags' => ['KantinSehat', 'Lingkungan', 'Adiwiyata'],
            ],
        ];

        foreach ($articles as $aData) {
            $tagNames = $aData['tags'] ?? [];
            unset($aData['tags']);
            
            $article = Article::create($aData);
            
            // Attach tags
            $tagIds = [];
            foreach ($tagNames as $tName) {
                if (isset($tags[$tName])) {
                    $tagIds[] = $tags[$tName]->id;
                }
            }
            $article->tags()->sync($tagIds);

            // Add sample approved comment
            Comment::create([
                'article_id' => $article->id,
                'user_id' => $pembaca->id,
                'name' => $pembaca->name,
                'email' => $pembaca->email,
                'content' => 'Selamat untuk seluruh tim dan keluarga besar SMPN 9 Probolinggo. Terus pertahankan budaya prestasi dan kepedulian lingkungan ini!',
                'status' => 'approved',
                'ip_address' => '127.0.0.1',
            ]);
        }

        // 8. Photo Gallery
        $gallery = Gallery::create([
            'title' => 'Dokumentasi Gelar Seni dan Pelepasan Kontingen Pramuka SPELAND',
            'slug' => 'dokumentasi-gelar-seni-pelepasan-kontingen-pramuka',
            'description' => 'Rangkaian foto penampilan tari tradisional, paduan suara, dan upacara penyematan tanda regu penggalang.',
            'category' => 'Kegiatan Sekolah',
            'user_id' => $fotografer->id,
            'cover_image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1000&q=80',
            'is_published' => true,
            'views_count' => 340,
        ]);

        $photos = [
            ['image_path' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1000&q=80', 'caption' => 'Penampilan tari kolosal pembuka pameran seni murid.', 'photographer' => 'Dinda Permata', 'order' => 1],
            ['image_path' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1000&q=80', 'caption' => 'Paduan suara membawakan lagu Mars SMPN 9 Probolinggo.', 'photographer' => 'Dinda Permata', 'order' => 2],
            ['image_path' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1000&q=80', 'caption' => 'Penyematan tanda penghargaan oleh kepala sekolah kepada perwakilan regu.', 'photographer' => 'Dinda Permata', 'order' => 3],
        ];

        foreach ($photos as $p) {
            $p['gallery_id'] = $gallery->id;
            GalleryPhoto::create($p);
        }

        // 9. Video Jurnalistik
        Video::create([
            'title' => 'Video Profil Jurnalistik SPELAND: Menyuarakan Kreativitas Murid',
            'slug' => 'video-profil-jurnalistik-speland',
            'description' => 'Mengenal lebih dekat dapur redaksi Jurnalistik SPELAND SMP Negeri 9 Probolinggo.',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'youtube_id' => 'dQw4w9WgXcQ',
            'thumbnail' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80',
            'category' => 'Liputan Khusus',
            'user_id' => $pemred->id,
            'published_at' => now()->subDays(3),
            'is_published' => true,
            'views_count' => 840,
        ]);

        Video::create([
            'title' => 'Dokumentasi Flashmob dan Aksi Peduli Kebersihan Pantai Mayangan',
            'slug' => 'dokumentasi-aksi-peduli-pantai-mayangan',
            'description' => 'Aksi nyata kader Adiwiyata SPELAND membersihkan sampah plastik pesisir pantai Probolinggo.',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'youtube_id' => 'dQw4w9WgXcQ',
            'thumbnail' => 'https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?auto=format&fit=crop&w=800&q=80',
            'category' => 'Adiwiyata',
            'user_id' => $reporter->id,
            'published_at' => now()->subDays(6),
            'is_published' => true,
            'views_count' => 460,
        ]);

        // 10. Podcast SPELAND
        Podcast::create([
            'title' => 'SPELAND Podcast Ep. 1: Menguak Rahasia Juara Olimpiade Sains Bersama Nadia',
            'slug' => 'speland-podcast-ep-1-rahasia-juara-olimpiade-sains',
            'episode_number' => 1,
            'description' => 'Bincang santai inspiratif mengenai kiat membagi waktu belajar, hobi, dan organisasi di jenjang SMP.',
            'host' => 'Ahmad Fauzi',
            'guest' => 'Nadia Salsabila (Peraih Medali Perak OSN IPA 2026)',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'youtube_id' => 'dQw4w9WgXcQ',
            'duration' => '28:45',
            'thumbnail' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?auto=format&fit=crop&w=800&q=80',
            'user_id' => $pemred->id,
            'published_at' => now()->subDays(7),
            'is_published' => true,
            'listens_count' => 520,
        ]);

        Podcast::create([
            'title' => 'SPELAND Podcast Ep. 2: Literasi Digital dan Etika Bermedia Sosial Pelajar',
            'slug' => 'speland-podcast-ep-2-literasi-digital-etika-bermedia-sosial',
            'episode_number' => 2,
            'description' => 'Mengapa jejak digital itu abadi? Simak pandangan guru BK dan perwakilan OSIS dalam diskusi seru episode kedua.',
            'host' => 'Siti Rahmawati',
            'guest' => 'Bapak Danang Wicaksono, S.Kom. & Kevin Alvaro (Ketua OSIS)',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'youtube_id' => 'dQw4w9WgXcQ',
            'duration' => '34:10',
            'thumbnail' => 'https://images.unsplash.com/photo-1589903308904-1010c2294adc?auto=format&fit=crop&w=800&q=80',
            'user_id' => $editor->id,
            'published_at' => now()->subDays(2),
            'is_published' => true,
            'listens_count' => 310,
        ]);

        // 11. Special Coverage
        $specialCoverage = SpecialCoverage::create([
            'title' => 'Liputan Khusus: Semarak Gerakan Sekolah Adiwiyata Mandiri 2026',
            'slug' => 'liputan-khusus-sekolah-adiwiyata-mandiri-2026',
            'subtitle' => 'Kompilasi berita, dokumentasi foto, dan wawancara eksklusif jejak pelestarian lingkungan SPELAND.',
            'description' => 'Dokumentasi terpadu perjalanan SMPN 9 Probolinggo mewujudkan ekosistem sekolah ramah lingkungan berkelanjutan.',
            'banner_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1200&q=80',
            'is_active' => true,
        ]);

        $publishedArticles = Article::published()->take(3)->get();
        foreach ($publishedArticles as $index => $art) {
            $specialCoverage->articles()->attach($art->id, ['order' => $index + 1]);
        }
    }
}
