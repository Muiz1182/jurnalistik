<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Reporter / Author
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete(); // Editor
            $table->string('photographer_name')->nullable();
            
            $table->string('featured_image')->nullable();
            $table->string('image_caption')->nullable();
            
            // Status: draft, submitted, under_review, revision_required, approved, scheduled, published, archived
            $table->string('status', 30)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('scheduled_for')->nullable()->index();
            
            // Editorial flags
            $table->boolean('is_breaking')->default(false)->index();
            $table->boolean('is_headline')->default(false)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_editor_pick')->default(false);
            $table->boolean('allow_comments')->default(true);
            
            // Counters
            $table->unsignedBigInteger('views_count')->default(0)->index();
            $table->unsignedBigInteger('shares_count')->default(0);
            
            // SEO
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'published_at']);
        });

        Schema::create('article_tag', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['article_id', 'tag_id']);
        });

        Schema::create('article_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Who made the revision / decision
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->text('notes')->nullable(); // Revision feedback or editorial notes
            $table->longText('content_snapshot')->nullable(); // Saved state snapshot if needed
            $table->timestamps();
            
            $table->index(['article_id', 'created_at']);
        });

        // Add PostgreSQL Full Text Search GIN index
        if (config('database.default') === 'pgsql') {
            DB::statement("CREATE INDEX articles_search_idx ON articles USING gin(to_tsvector('indonesian', coalesce(title, '') || ' ' || coalesce(subtitle, '') || ' ' || coalesce(excerpt, '') || ' ' || coalesce(content, '')))");
        }
    }

    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            DB::statement("DROP INDEX IF EXISTS articles_search_idx");
        }
        Schema::dropIfExists('article_revisions');
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('articles');
    }
};
