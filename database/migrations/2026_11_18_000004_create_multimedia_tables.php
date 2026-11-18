<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Media Library
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('filename');
            $table->string('filepath');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size');
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->timestamps();
        });

        // Photo Galleries / Albums
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('category')->default('Kegiatan Sekolah');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });

        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->string('photographer')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Videos
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('youtube_url');
            $table->string('youtube_id', 50);
            $table->string('thumbnail')->nullable();
            $table->string('category')->default('Liputan');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });

        // Podcasts
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('episode_number')->default(1);
            $table->text('description')->nullable();
            $table->string('host')->nullable();
            $table->string('guest')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('youtube_id', 50)->nullable();
            $table->string('audio_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('duration', 20)->nullable(); // e.g. "32:15"
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('listens_count')->default(0);
            $table->timestamps();
        });

        // Special Coverage (Liputan Khusus)
        Schema::create('special_coverages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('special_coverage_articles', function (Blueprint $table) {
            $table->foreignId('special_coverage_id')->constrained('special_coverages')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->primary(['special_coverage_id', 'article_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('special_coverage_articles');
        Schema::dropIfExists('special_coverages');
        Schema::dropIfExists('podcasts');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('media');
    }
};
