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
            ['name' => 'Literasi', 'slug' => 'literasi', 'color' => '#BE185D', 'order' => 7, 'description' => 'Gerakan membaca, resensi buku perpustakaan, dan karya puisi murid'],
            ['name' => 'Opini', 'slug' => 'opini', 'color' => '#C2410C', 'order' => 8, 'description' => 'Sudut pandang murid, gagasan kritis guru, dan esai pendidikan'],
            ['name' => 'Informasi Sekolah', 'slug' => 'informasi-sekolah', 'color' => '#334155', 'order' => 9, 'description' => 'Pengumuman resmi kedinasan, jadwal akademik, dan agenda resmi'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::create($c);
        }

        // 3. Official Accounts Requested
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@jurnalistik.mmaproduction.com',
            'password' => Hash::make('admin1182'),
            'role_id' => $roles['super-admin']->id,
            'title' => 'Super Administrator',
            'bio' => 'Pengelola sistem digital dan infrastruktur media pers Jurnalistik SPELAND.',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Kepala Divisi Redaksi',
            'username' => 'kadiv',
            'email' => 'kadiv@jurnalistik.mmaproduction.com',
            'password' => Hash::make('kadiv1182'),
            'role_id' => $roles['pemimpin-redaksi']->id,
            'title' => 'Kepala Divisi (Kadiv)',
            'bio' => 'Kepala Divisi dan penanggung jawab penerbitan berita Jurnalistik SPELAND.',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Editor Redaksi',
            'username' => 'editor',
            'email' => 'editor@jurnalistik.mmaproduction.com',
            'password' => Hash::make('editor1182'),
            'role_id' => $roles['editor']->id,
            'title' => 'Editor Berita',
            'bio' => 'Penyunting naskah, pemeriksa fakta, dan tata bahasa jurnalistik.',
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
            'chief_editor' => '-',
            'advisor_name' => '-',
            'about_brief' => 'Jurnalistik SPELAND merupakan media informasi, komunikasi, dan publikasi digital resmi SMP Negeri 9 Probolinggo yang dikelola langsung oleh tim jurnalis pelajar sekolah.',
            'editorial_policy' => 'Redaksi Jurnalistik SPELAND menjunjung tinggi independensi fakta, etika pemberitaan ramah anak, ketepatan verifikasi, dan keberpihakan pada nilai-nilai pendidikan karakter.',
            'breaking_news_active' => '0',
            'breaking_news_text' => '',
            'breaking_news_url' => '',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }
    }
}
