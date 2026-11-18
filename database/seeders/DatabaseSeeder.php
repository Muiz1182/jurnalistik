<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EditorialMember;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles and Permissions (RBAC)
        $rolesData = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Akses mutlak terhadap seluruh sistem portal berita dan konfigurasi.'],
            ['name' => 'Pemimpin Redaksi', 'slug' => 'pemimpin-redaksi', 'description' => 'Penanggung jawab redaksi, persetujuan publikasi akhir, dan penugasan.'],
            ['name' => 'Editor', 'slug' => 'editor', 'description' => 'Penyunting naskah berita, koreksi fakta, dan pemberi catatan revisi.'],
            ['name' => 'Reporter', 'slug' => 'reporter', 'description' => 'Jurnalis sekolah pembuat naskah berita, liputan, dan esai.'],
            ['name' => 'Fotografer', 'slug' => 'fotografer', 'description' => 'Pengunggah dokumentasi visual, album foto, dan pengelola multimedia.'],
            ['name' => 'Pembaca', 'slug' => 'pembaca', 'description' => 'Pengguna umum terdaftar, pembaca, pemberi komentar, dan penyimpan bookmark.'],
        ];

        $roles = [];
        foreach ($rolesData as $r) {
            $roles[$r['slug']] = Role::create($r);
        }

        // 2. Official News Categories (Rubrikasi Berita SMPN 9 Probolinggo)
        $categoriesData = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'color' => '#1E3A8A', 'order' => 1, 'description' => 'Kabar kurikulum, asesmen, literasi kelas, dan metode pembelajaran inovatif'],
            ['name' => 'Kegiatan Sekolah', 'slug' => 'kegiatan', 'color' => '#0D9488', 'order' => 2, 'description' => 'Liputan upacara, perayaan hari besar, karya P5, dan dinamika warga sekolah'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'color' => '#D97706', 'order' => 3, 'description' => 'Pencapaian gemilang murid dan guru di bidang akademik, seni, dan olahraga'],
            ['name' => 'Adiwiyata & Lingkungan', 'slug' => 'lingkungan', 'color' => '#15803D', 'order' => 4, 'description' => 'Gerakan peduli sampah, kebun sekolah, biopori, dan konservasi hijau'],
            ['name' => 'Sekolah', 'slug' => 'sekolah', 'color' => '#2563EB', 'order' => 5, 'description' => 'Profil fasilitas, sarana prasarana, dan perkembangan lingkungan belajar'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'color' => '#0284C7', 'order' => 6, 'description' => 'Inovasi laboratorium komputer, pembelajaran digital, dan literasi internet sehat'],
            ['name' => 'Organisasi', 'slug' => 'organisasi', 'color' => '#6D28D9', 'order' => 7, 'description' => 'Kiprah OSIS, Pramuka, PMR, Paskibra, dan ekstrakurikuler sekolah'],
            ['name' => 'Literasi', 'slug' => 'literasi', 'color' => '#BE185D', 'order' => 8, 'description' => 'Gerakan membaca, resensi buku perpustakaan, dan karya puisi murid'],
            ['name' => 'Opini', 'slug' => 'opini', 'color' => '#C2410C', 'order' => 9, 'description' => 'Sudut pandang murid, gagasan kritis guru, dan esai pendidikan'],
            ['name' => 'Informasi Sekolah', 'slug' => 'informasi-sekolah', 'color' => '#334155', 'order' => 10, 'description' => 'Pengumuman resmi kedinasan, jadwal akademik, dan agenda resmi'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::create($c);
        }

        // 3. Editorial Team Users (Official Accounts)
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
            'title' => 'Reporter Lapangan',
            'bio' => 'Jurnalis pelajar peliput kegiatan ekstrakurikuler dan prestasi murid.',
            'status' => 'active',
        ]);

        $fotografer = User::create([
            'name' => 'Dinda Permata',
            'username' => 'fotografer',
            'email' => 'fotografer@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['fotografer']->id,
            'title' => 'Fotografer Redaksi',
            'bio' => 'Koordinator divisi dokumentasi foto dan visual pers sekolah.',
            'status' => 'active',
        ]);

        $pembaca = User::create([
            'name' => 'Budi Santoso',
            'username' => 'pembaca',
            'email' => 'pembaca@speland.sch.id',
            'password' => Hash::make('password123'),
            'role_id' => $roles['pembaca']->id,
            'title' => 'Alumni & Pembaca',
            'bio' => 'Pemerhati karya jurnalistik pelajar Kota Probolinggo.',
            'status' => 'active',
        ]);

        // 4. Tags
        $tagsData = ['Adiwiyata', 'OSIS', 'Olimpiade', 'Pramuka', 'LiterasiSekolah', 'KotaProbolinggo', 'KaryaMurid', 'P5KurikulumMerdeka', 'KantinSehat', 'SeniBudaya'];
        foreach ($tagsData as $t) {
            Tag::create(['name' => $t, 'slug' => Str::slug($t)]);
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
            'breaking_news_active' => '0',
            'breaking_news_text' => '',
            'breaking_news_url' => '',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 6. Editorial Members Structure (Struktur Redaksi Resmi SMPN 9 Probolinggo)
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
    }
}
