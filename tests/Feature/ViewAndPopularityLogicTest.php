<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewAndPopularityLogicTest extends TestCase
{
    protected User $author;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(
            ['slug' => 'reporter'],
            ['name' => 'Reporter', 'description' => 'Reporter']
        );

        $this->author = User::firstOrCreate(
            ['email' => 'testauthor@speland.sch.id'],
            [
                'name' => 'Test Author',
                'username' => 'testauthor',
                'password' => bcrypt('password'),
                'role_id' => $role->id,
                'status' => 'active',
            ]
        );

        $this->category = Category::firstOrCreate(
            ['slug' => 'pendidikan'],
            ['name' => 'Pendidikan', 'color' => '#1E3A8A', 'is_active' => true, 'order' => 1]
        );
    }

    public function test_article_view_increments_and_deduplicates_per_session(): void
    {
        $article = Article::create([
            'title' => 'Uji Coba Pembaca Jurnalistik SPELAND',
            'slug' => 'uji-coba-pembaca-jurnalistik-speland',
            'content' => 'Konten uji coba pembaca artikel.',
            'category_id' => $this->category->id,
            'user_id' => $this->author->id,
            'status' => 'published',
            'published_at' => now(),
            'views_count' => 0,
        ]);

        // 1. First visit from Session A on IP 127.0.0.1 -> Increments views
        $tracked1 = ArticleView::track($article, '127.0.0.1', 'session_A');
        $this->assertTrue($tracked1);
        $this->assertEquals(1, $article->fresh()->views_count);

        // 2. Second visit immediately from the same Session A -> Deduplicated (no increment)
        $tracked2 = ArticleView::track($article, '127.0.0.1', 'session_A');
        $this->assertFalse($tracked2);
        $this->assertEquals(1, $article->fresh()->views_count);

        // 3. Third visit from a DIFFERENT student/device on the same local network / WiFi (Session B on 127.0.0.1) -> Increments views!
        session()->flush();
        $tracked3 = ArticleView::track($article, '127.0.0.1', 'session_B');
        $this->assertTrue($tracked3);
        $this->assertEquals(2, $article->fresh()->views_count);

        // Clean up test article
        $article->forceDelete();
    }

    public function test_get_popular_ranks_by_views_and_smart_backfill(): void
    {
        // Create 3 articles with different view counts
        $a1 = Article::create([
            'title' => 'Berita Peringkat 1',
            'slug' => 'berita-peringkat-1-' . uniqid(),
            'content' => 'Konten',
            'category_id' => $this->category->id,
            'user_id' => $this->author->id,
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'views_count' => 150,
        ]);

        $a2 = Article::create([
            'title' => 'Berita Peringkat 2',
            'slug' => 'berita-peringkat-2-' . uniqid(),
            'content' => 'Konten',
            'category_id' => $this->category->id,
            'user_id' => $this->author->id,
            'status' => 'published',
            'published_at' => now()->subDays(10),
            'views_count' => 80,
        ]);

        $a3 = Article::create([
            'title' => 'Berita Peringkat 3 Evergreen',
            'slug' => 'berita-peringkat-3-' . uniqid(),
            'content' => 'Konten',
            'category_id' => $this->category->id,
            'user_id' => $this->author->id,
            'status' => 'published',
            'published_at' => now()->subDays(60), // Older than 30 days
            'views_count' => 50,
        ]);

        $popular = Article::getPopular(5);

        $this->assertNotEmpty($popular);
        // Peringkat 1 should be $a1 with 150 views
        $this->assertEquals($a1->id, $popular->first()->id);
        $this->assertTrue($popular->contains('id', $a2->id));
        // Evergreen article older than 30 days is included through smart backfill
        $this->assertTrue($popular->contains('id', $a3->id));

        // Clean up
        $a1->forceDelete();
        $a2->forceDelete();
        $a3->forceDelete();
    }

    public function test_homepage_renders_all_features_without_error(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('JURNALISTIK');
        $response->assertSee('SPELAND');
    }
}
