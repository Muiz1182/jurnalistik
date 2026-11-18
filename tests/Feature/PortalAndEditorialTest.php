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
}
