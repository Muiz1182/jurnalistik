<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class EditorialWorkflowLiveTest extends TestCase
{
    public function test_reporter_can_create_draft_and_submit_to_editor(): void
    {
        $editor = User::where('username', 'editor')->first();
        $kadiv = User::where('username', 'kadiv')->first();
        $category = Category::where('slug', 'kegiatan')->first();

        // 1. Editor stores a draft article
        $response = $this->actingAs($editor)->post('/admin/articles', [
            'title' => 'Liputan Kegiatan Bersih Sekolah Hari Jumat',
            'subtitle' => 'Kader Adiwiyata ajak seluruh kelas rawat kebun sekolah',
            'category_id' => $category->id,
            'excerpt' => 'Kegiatan rutin Jumat Bersih kembali digelar di lapangan utama.',
            'content' => '<p>Seluruh murid kelas 7 hingga 9 bergotong royong membersihkan area taman.</p>',
            'action' => 'save_draft',
        ]);

        $response->assertRedirect('/admin/articles');

        $article = Article::where('slug', 'liputan-kegiatan-bersih-sekolah-hari-jumat')->first();
        $this->assertNotNull($article);
        $this->assertEquals('draft', $article->status);

        // 2. Submit to review
        $submitResponse = $this->actingAs($editor)->post("/admin/articles/{$article->id}/submit");
        $submitResponse->assertStatus(302);

        $article->refresh();
        $this->assertEquals('submitted', $article->status);

        // 3. Kadiv reviews article
        $reviewResponse = $this->actingAs($kadiv)->post("/admin/articles/{$article->id}/review");
        $reviewResponse->assertStatus(302);

        $article->refresh();
        $this->assertEquals('under_review', $article->status);

        // 4. Kadiv approves article
        $approveResponse = $this->actingAs($kadiv)->post("/admin/articles/{$article->id}/approve");
        $approveResponse->assertStatus(302);

        $article->refresh();
        $this->assertEquals('approved', $article->status);

        // 5. Kadiv publishes article
        $publishResponse = $this->actingAs($kadiv)->post("/admin/articles/{$article->id}/publish");
        $publishResponse->assertStatus(302);

        $article->refresh();
        $this->assertEquals('published', $article->status);
        $this->assertNotNull($article->published_at);

        // 6. Article is now live on public homepage & detail page
        $publicShow = $this->get("/berita/{$article->slug}");
        $publicShow->assertStatus(200);
        $publicShow->assertSee('Liputan Kegiatan Bersih Sekolah Hari Jumat');

        // Clean up test article
        $article->revisions()->delete();
        $article->forceDelete();
    }
}
