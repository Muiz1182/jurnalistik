<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class PortalAndEditorialTest extends TestCase
{
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('JURNALISTIK SPELAND');
    }

    public function test_public_articles_and_search(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);

        $searchResponse = $this->get('/cari?q=sekolah');
        $searchResponse->assertStatus(200);
    }

    public function test_multimedia_sections(): void
    {
        $this->get('/galeri')->assertStatus(200);
        $this->get('/video')->assertStatus(200);
        $this->get('/podcast')->assertStatus(200);
        $this->get('/liputan-khusus')->assertStatus(200);
    }

    public function test_static_information_pages(): void
    {
        $this->get('/tentang-kami')->assertStatus(200);
        $this->get('/struktur-redaksi')->assertStatus(200);
        $this->get('/kontak-redaksi')->assertStatus(200);
        $this->get('/kebijakan-redaksi')->assertStatus(200);
        $this->get('/pedoman-pemberitaan')->assertStatus(200);
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::where('username', 'admin')->first();
        if ($admin) {
            $response = $this->actingAs($admin)->get('/admin');
            $response->assertStatus(200);
        }
    }

    public function test_admin_can_upload_and_remove_site_logo(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);

        $fakeLogo = \Illuminate\Http\UploadedFile::fake()->image('custom-speland-logo.png', 200, 200);

        $updateResponse = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'JURNALISTIK SPELAND',
            'site_tagline' => 'Mengabarkan Fakta, Menyuarakan Cerita.',
            'site_logo' => $fakeLogo,
        ]);

        $updateResponse->assertSessionHas('success');
        $storedLogo = Setting::get('site_logo');
        $this->assertNotNull($storedLogo);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($storedLogo);

        // Verify public view sees the logo
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee(asset('storage/' . $storedLogo));

        // Test removing the logo
        $removeResponse = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'JURNALISTIK SPELAND',
            'site_tagline' => 'Mengabarkan Fakta, Menyuarakan Cerita.',
            'remove_logo' => '1',
        ]);

        $removeResponse->assertSessionHas('success');
        $this->assertNull(Setting::get('site_logo'));
    }

    public function test_toast_notifications_render_in_admin_and_public(): void
    {
        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);

        // Public page with session flash
        $publicResponse = $this->withSession(['success' => 'Operasi publik berhasil dilakukan!'])->get('/');
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('spelandToastManager');
        $publicResponse->assertSee('Operasi publik berhasil dilakukan!');

        // Admin page with session flash
        $adminResponse = $this->actingAs($admin)
            ->withSession(['success' => 'Perubahan sistem berhasil disimpan!'])
            ->get(route('admin.dashboard'));
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('spelandToastManager');
        $adminResponse->assertSee('Perubahan sistem berhasil disimpan!');
    }

    public function test_tiktok_social_media_setting_and_display(): void
    {
        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);

        // Update TikTok setting
        $updateResponse = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'social_tiktok' => 'https://www.tiktok.com/@smpn9probolinggo_official',
            'social_instagram' => 'https://instagram.com/smpn9probolinggo_official',
            'social_youtube' => 'https://youtube.com/@smpnegeri9probolinggo',
        ]);
        $updateResponse->assertSessionHas('success');
        $this->assertEquals('https://www.tiktok.com/@smpn9probolinggo_official', Setting::get('social_tiktok'));

        // Check public sees TikTok
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('https://www.tiktok.com/@smpn9probolinggo_official');
        $homeResponse->assertSee('TikTok');
    }

    public function test_article_and_file_are_permanently_deleted_from_database_and_storage(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);

        // Upload fake image file
        $fakeFile = \Illuminate\Http\UploadedFile::fake()->image('liputan-berita.jpg', 640, 480);
        $storedPath = $fakeFile->store('articles', 'public');
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($storedPath);

        $category = Category::first();
        $article = Article::create([
            'title' => 'Berita Uji Coba Hapus Permanen',
            'slug' => 'berita-uji-coba-hapus-permanen',
            'content' => 'Konten artikel uji coba hapus permanen.',
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'featured_image' => $storedPath,
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('articles', ['id' => $article->id]);

        // Delete article via admin controller
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.articles.destroy', $article));
        $deleteResponse->assertRedirect(route('admin.articles.index'));
        $deleteResponse->assertSessionHas('success');

        // Verify permanently deleted from database (row does not exist at all)
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);

        // Verify physical file was deleted from storage disk
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($storedPath);
    }
}
