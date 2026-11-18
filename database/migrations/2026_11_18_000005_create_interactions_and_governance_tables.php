<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Comments with moderation
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->text('content');
            // status: pending, approved, rejected, spam
            $table->string('status', 20)->default('pending')->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // Bookmarks for logged in users
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->timestamps();
            
            $table->unique(['user_id', 'article_id']);
        });

        // Article Views Analytics (prevent spam views)
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->string('session_id', 100)->nullable();
            $table->date('viewed_date')->index();
            $table->timestamp('viewed_at');
            
            $table->index(['article_id', 'viewed_date']);
        });

        // Editorial Assignments
        Schema::create('editorial_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('brief');
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('article_id')->nullable()->constrained('articles')->nullOnDelete();
            $table->date('deadline')->nullable();
            // status: assigned, in_progress, submitted, completed, cancelled
            $table->string('status', 30)->default('assigned');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Editorial Members (Struktur Organisasi Redaksi)
        Schema::create('editorial_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // Pembina, Pemimpin Redaksi, Redaktur Pelaksana, Editor, Reporter, Fotografer, Videografer
            $table->string('division')->default('Redaksi'); // Pembina, Pimpinan, Dewan Redaksi, Reporter, Multimedia, Tim Kreatif
            $table->string('class_or_grade')->nullable(); // e.g. "Kelas 8A", "Guru Pembina"
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // System Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group', 50)->default('general'); // general, editorial, social, contact, about
            $table->string('type', 20)->default('text'); // text, textarea, boolean, image
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 50); // login, create_article, update_status, publish, delete, etc.
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description');
            $table->jsonb('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            $table->index(['action', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('editorial_members');
        Schema::dropIfExists('editorial_assignments');
        Schema::dropIfExists('article_views');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('comments');
    }
};
