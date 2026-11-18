<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditorKadivWorkflowTest extends TestCase
{
    public function test_full_editor_to_kadiv_approval_and_publication_workflow(): void
    {
        // 1. Get Accounts
        $editor = User::where('email', 'editor@jurnalistik.mmaproduction.com')->first();
        $kadiv = User::where('email', 'kadiv@jurnalistik.mmaproduction.com')->first();
        $category = Category::first() ?? Category::create(['name' => 'Pendidikan', 'slug' => 'pendidikan', 'is_active' => true]);

        $this->assertNotNull($editor, 'Editor account must exist');
        $this->assertNotNull($kadiv, 'Kadiv account must exist');

        // Cleanup any previous run
        Article::withTrashed()->where('title', 'like', '%Liputan Kegiatan P5 Speland 2026%')->forceDelete();

        // 2. Editor logs in and creates a draft article
        $this->actingAs($editor);

        $response = $this->post(route('admin.articles.store'), [
            'title' => 'Liputan Kegiatan P5 Speland 2026',
            'category_id' => $category->id,
            'summary' => 'Ringkasan liputan kegiatan P5 di SMP Negeri 9 Probolinggo.',
            'content' => '<p>Murid-murid SMPN 9 Probolinggo sangat antusias mengikuti kegiatan P5 bertema kearifan lokal.</p>',
            'action' => 'draft',
        ]);

        $response->assertRedirect();

        $article = Article::where('slug', 'liputan-kegiatan-p5-speland-2026')->first();
        $this->assertNotNull($article);
        $this->assertEquals('draft', $article->status);
        $this->assertEquals($editor->id, $article->user_id);

        // 3. Editor submits the article for approval by Kadiv
        $submitResponse = $this->post(route('admin.articles.submit', $article));
        $submitResponse->assertRedirect();

        $article->refresh();
        $this->assertEquals('submitted', $article->status);

        // 4. Kadiv logs in and reviews the article
        $this->actingAs($kadiv);

        $reviewResponse = $this->post(route('admin.articles.review', $article));
        $reviewResponse->assertRedirect();

        $article->refresh();
        $this->assertEquals('under_review', $article->status);
        $this->assertEquals($kadiv->id, $article->editor_id);

        // 5. Kadiv asks for revision
        $revisionResponse = $this->post(route('admin.articles.revision', $article), [
            'notes' => 'Tolong lengkapi nama koordinator P5 dan kutipan dari Kepala Sekolah.',
        ]);
        $revisionResponse->assertRedirect();

        $article->refresh();
        $this->assertEquals('revision_required', $article->status);

        // 6. Editor logs in, revises content, and re-submits to Kadiv
        $this->actingAs($editor);

        $updateResponse = $this->put(route('admin.articles.update', $article), [
            'title' => 'Liputan Kegiatan P5 Speland 2026 Lengkap',
            'category_id' => $category->id,
            'summary' => 'Ringkasan liputan kegiatan P5 di SMP Negeri 9 Probolinggo dengan kutipan Kepala Sekolah.',
            'content' => '<p>Kepala SMPN 9 Probolinggo menyampaikan apresiasi tinggi atas karya inovatif murid.</p>',
            'action' => 'submit',
        ]);
        $updateResponse->assertRedirect();

        $article->refresh();
        $this->assertEquals('submitted', $article->status);

        // 7. Kadiv approves and publishes directly to the digital news portal
        $this->actingAs($kadiv);

        $publishResponse = $this->post(route('admin.articles.publish', $article));
        $publishResponse->assertRedirect();

        $article->refresh();
        $this->assertEquals('published', $article->status);
        $this->assertNotNull($article->published_at);

        // 8. Public visitor can read the published article
        auth()->logout();
        $publicResponse = $this->get(route('articles.show', $article->slug));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Liputan Kegiatan P5 Speland 2026 Lengkap');
    }
}
