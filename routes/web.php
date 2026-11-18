<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EditorialMemberController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PodcastController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SpecialCoverageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MultimediaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes — JURNALISTIK SPELAND News Portal
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/struktur-redaksi', [HomeController::class, 'editorialStructure'])->name('editorial.structure');
Route::get('/kontak-redaksi', [HomeController::class, 'contact'])->name('contact');
Route::get('/kebijakan-redaksi', [HomeController::class, 'editorialPolicy'])->name('editorial.policy');
Route::get('/pedoman-pemberitaan', [HomeController::class, 'journalisticGuidelines'])->name('journalistic.guidelines');

// Articles & Editorial Sections
Route::get('/berita', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/berita/populer', [ArticleController::class, 'popular']);
Route::get('/berita/terbaru', [ArticleController::class, 'latest']);
Route::get('/berita/kategori/{slug}', [ArticleController::class, 'category']);
Route::get('/berita/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/kategori/{slug}', [ArticleController::class, 'category'])->name('articles.category');
Route::get('/populer', [ArticleController::class, 'popular'])->name('articles.popular');
Route::get('/terbaru', [ArticleController::class, 'latest'])->name('articles.latest');
Route::get('/opini', [ArticleController::class, 'opinion'])->name('articles.opinion');
Route::get('/cari', [ArticleController::class, 'search'])->name('articles.search');
Route::get('/arsip', [ArticleController::class, 'archive'])->name('articles.archive');

// Multimedia Section
Route::get('/galeri', [MultimediaController::class, 'galleries'])->name('multimedia.galleries');
Route::get('/galeri-foto', [MultimediaController::class, 'galleries']);
Route::get('/galeri/{slug}', [MultimediaController::class, 'galleryShow'])->name('multimedia.gallery.show');
Route::get('/galeri-foto/{slug}', [MultimediaController::class, 'galleryShow']);
Route::get('/video', [MultimediaController::class, 'videos'])->name('multimedia.videos');
Route::get('/podcast', [MultimediaController::class, 'podcasts'])->name('multimedia.podcasts');
Route::get('/liputan-khusus', [MultimediaController::class, 'specialCoverages'])->name('multimedia.special-coverages');
Route::get('/liputan-khusus/{slug}', [MultimediaController::class, 'specialCoverageShow'])->name('multimedia.special-coverage.show');

// Interaction (Comments & Bookmarks)
Route::post('/berita/{article}/komentar', [CommentController::class, 'store'])->name('comments.store');
Route::post('/berita/{article}/bookmark', [ArticleController::class, 'toggleBookmark'])->name('articles.bookmark');
Route::get('/bookmark-saya', [ArticleController::class, 'myBookmarks'])->name('articles.bookmarks')->middleware('auth');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin & Newsroom Editorial Management System
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role'])->group(function () {
    // Dashboard Overview
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // News Management (Articles)
    Route::resource('articles', AdminArticleController::class);
    // Editorial Workflow Routes
    Route::post('articles/{article}/submit', [AdminArticleController::class, 'submitToEditor'])->name('articles.submit');
    Route::post('articles/{article}/review', [AdminArticleController::class, 'review'])->name('articles.review');
    Route::post('articles/{article}/revision', [AdminArticleController::class, 'revisionRequired'])->name('articles.revision');
    Route::post('articles/{article}/approve', [AdminArticleController::class, 'approve'])->name('articles.approve');
    Route::post('articles/{article}/publish', [AdminArticleController::class, 'publish'])->name('articles.publish');
    Route::post('articles/{article}/archive', [AdminArticleController::class, 'archive'])->name('articles.archive');

    // Categories & Tags
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('tags', TagController::class)->except(['create', 'show', 'edit']);

    // Multimedia & Library
    Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy']);
    Route::resource('galleries', GalleryController::class)->except(['show']);
    Route::delete('gallery-photos/{photo}', [GalleryController::class, 'destroyPhoto'])->name('gallery-photos.destroy');
    Route::resource('videos', VideoController::class)->except(['show']);
    Route::resource('podcasts', PodcastController::class)->except(['show']);
    Route::resource('special-coverages', SpecialCoverageController::class)->except(['show']);

    // User & Editorial Management
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('editorial-members', EditorialMemberController::class)->except(['create', 'show', 'edit']);

    // Comment Moderation
    Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::post('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::post('comments/{comment}/spam', [AdminCommentController::class, 'markSpam'])->name('comments.spam');
    Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    // Assignments
    Route::resource('assignments', AssignmentController::class)->only(['index', 'store', 'destroy']);
    Route::patch('assignments/{assignment}/status', [AssignmentController::class, 'updateStatus'])->name('assignments.updateStatus');

    // Analytics & Logs
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
