<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $query = Article::with(['category', 'author', 'editor']);

        // Reporter can only see their own articles unless they have editor/pemred rights
        if ($user->hasRole('reporter')) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('excerpt', 'like', "%{$term}%");
            });
        }

        $articles = $query->latest('updated_at')->paginate(15)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        // Status counts for tabs
        $baseCountQuery = Article::query();
        if ($user->hasRole('reporter')) {
            $baseCountQuery->where('user_id', $user->id);
        }

        $counts = [
            'all' => (clone $baseCountQuery)->count(),
            'draft' => (clone $baseCountQuery)->where('status', 'draft')->count(),
            'submitted' => (clone $baseCountQuery)->where('status', 'submitted')->count(),
            'under_review' => (clone $baseCountQuery)->where('status', 'under_review')->count(),
            'revision_required' => (clone $baseCountQuery)->where('status', 'revision_required')->count(),
            'approved' => (clone $baseCountQuery)->where('status', 'approved')->count(),
            'published' => (clone $baseCountQuery)->where('status', 'published')->count(),
            'archived' => (clone $baseCountQuery)->where('status', 'archived')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'categories', 'counts'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'photographer_name' => 'nullable|string|max:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_caption' => 'nullable|string|max:255',
            'action' => 'required|in:draft,save_draft,submit,publish',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'is_breaking' => 'nullable|boolean',
            'is_headline' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'scheduled_for' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }

        // Determine initial status based on user role and action button
        $status = 'draft';
        $publishedAt = null;

        if ($validated['action'] === 'submit') {
            $status = 'submitted';
        } elseif ($validated['action'] === 'publish' && $user->canPublishArticles()) {
            if (!empty($validated['scheduled_for']) && strtotime($validated['scheduled_for']) > time()) {
                $status = 'scheduled';
            } else {
                $status = 'published';
                $publishedAt = now();
            }
        }

        $article = Article::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'user_id' => $user->id,
            'editor_id' => ($status === 'published' && $user->canPublishArticles()) ? $user->id : null,
            'photographer_name' => $validated['photographer_name'] ?? null,
            'featured_image' => $imagePath,
            'image_caption' => $validated['image_caption'] ?? null,
            'status' => $status,
            'published_at' => $publishedAt,
            'scheduled_for' => $validated['scheduled_for'] ?? null,
            'is_breaking' => $request->boolean('is_breaking'),
            'is_headline' => $request->boolean('is_headline'),
            'is_featured' => $request->boolean('is_featured'),
            'allow_comments' => $request->boolean('allow_comments', true),
            'seo_title' => $validated['seo_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        // Process tags
        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                if (trim($tagName) === '') continue;
                $tag = Tag::firstOrCreate(['name' => trim($tagName)], ['slug' => Str::slug($tagName)]);
                $tagIds[] = $tag->id;
            }
            $article->tags()->sync($tagIds);
        }

        // Log Revision History
        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => null,
            'to_status' => $status,
            'notes' => 'Naskah pertama kali dibuat.',
            'content_snapshot' => $article->content,
        ]);

        ActivityLog::log('create_article', "Membuat artikel '{$article->title}' dengan status [{$status}].", $article);

        return redirect()->route('admin.articles.index')->with('success', "Artikel berhasil disimpan dengan status [{$status}].");
    }

    public function edit(Article $article): View
    {
        $user = auth()->user();

        // Authority check
        if (!$user->isPemimpinRedaksi()) {
            if ($article->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki hak untuk menyunting naskah milik pengguna lain.');
            }
            if ($article->status === 'published') {
                abort(403, 'Artikel yang sudah diterbitkan hanya dapat disunting oleh Kadiv atau Super Admin.');
            }
        }

        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $tags = Tag::orderBy('name')->get();
        $revisions = $article->revisions()->with('user')->get();

        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'revisions'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isPemimpinRedaksi()) {
            if ($article->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki hak untuk menyunting naskah milik pengguna lain.');
            }
            if ($article->status === 'published') {
                abort(403, 'Artikel yang sudah diterbitkan hanya dapat disunting oleh Kadiv atau Super Admin.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'photographer_name' => 'nullable|string|max:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_caption' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'is_breaking' => 'nullable|boolean',
            'is_headline' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'scheduled_for' => 'nullable|date',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image && !Str::startsWith($article->featured_image, 'http')) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $article->featured_image = $request->file('featured_image')->store('articles', 'public');
        }

        $oldStatus = $article->status;

        $article->title = $validated['title'];
        $article->subtitle = $validated['subtitle'] ?? null;
        $article->category_id = $validated['category_id'];
        $article->excerpt = $validated['excerpt'] ?? null;
        $article->content = $validated['content'];
        $article->photographer_name = $validated['photographer_name'] ?? null;
        $article->image_caption = $validated['image_caption'] ?? null;
        $article->scheduled_for = $validated['scheduled_for'] ?? null;
        $article->is_breaking = $request->boolean('is_breaking');
        $article->is_headline = $request->boolean('is_headline');
        $article->is_featured = $request->boolean('is_featured');
        $article->allow_comments = $request->boolean('allow_comments', true);
        $article->seo_title = $validated['seo_title'] ?? null;
        $article->meta_description = $validated['meta_description'] ?? null;

        // Process workflow action if submitted from editor form
        $action = $request->input('action');
        if ($action === 'submit' && in_array($article->status, ['draft', 'revision_required'])) {
            $article->status = 'submitted';
            ArticleRevision::create([
                'article_id' => $article->id,
                'user_id' => $user->id,
                'from_status' => $oldStatus,
                'to_status' => 'submitted',
                'notes' => 'Editor mengajukan naskah kepada Kadiv untuk memohon persetujuan publikasi.',
                'content_snapshot' => $article->content,
            ]);
            ActivityLog::log('submit_article', "Editor mengajukan naskah '{$article->title}' ke Kadiv untuk persetujuan.", $article);
        } elseif ($action === 'publish' && $user->canPublishArticles()) {
            $article->status = 'published';
            $article->editor_id = $user->id;
            $article->published_at = $article->published_at ?? now();
            ArticleRevision::create([
                'article_id' => $article->id,
                'user_id' => $user->id,
                'from_status' => $oldStatus,
                'to_status' => 'published',
                'notes' => 'Kadiv menyetujui naskah dan menerbitkannya langsung ke website.',
                'content_snapshot' => $article->content,
            ]);
            ActivityLog::log('publish_article', "Kadiv menyetujui dan menerbitkan naskah '{$article->title}'.", $article);
        }

        $article->save();

        // Process tags
        if (isset($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                if (trim($tagName) === '') continue;
                $tag = Tag::firstOrCreate(['name' => trim($tagName)], ['slug' => Str::slug($tagName)]);
                $tagIds[] = $tag->id;
            }
            $article->tags()->sync($tagIds);
        }

        ActivityLog::log('update_article', "Memperbarui isi artikel '{$article->title}'.", $article);

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Perubahan artikel berhasil disimpan.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isPemimpinRedaksi()) {
            if ($article->user_id !== $user->id) {
                abort(403, 'Anda hanya dapat menghapus naskah milik Anda sendiri.');
            }
            if ($article->status === 'published') {
                abort(403, 'Artikel yang sudah diterbitkan hanya dapat dihapus atau diarsipkan oleh Kadiv atau Super Admin.');
            }
        }

        $title = $article->title;
        $article->delete();

        ActivityLog::log('delete_article', "Menghapus artikel '{$title}'.");

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    // Editorial Workflow Transitions (Editor -> Kadiv Approval)

    public function submitToEditor(Article $article): RedirectResponse
    {
        $user = auth()->user();
        if ($article->user_id !== $user->id && !$user->canPublishArticles()) {
            abort(403);
        }

        $fromStatus = $article->status;
        $article->update(['status' => 'submitted']);

        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => $fromStatus,
            'to_status' => 'submitted',
            'notes' => 'Editor mengajukan naskah kepada Kadiv untuk memohon persetujuan publikasi.',
        ]);

        ActivityLog::log('workflow_submit', "Mengajukan naskah '{$article->title}' untuk persetujuan Kadiv.", $article);

        return back()->with('success', 'Naskah berhasil diajukan ke Kadiv untuk meminta persetujuan penerbitan.');
    }

    public function review(Article $article): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canPublishArticles() && !$user->canReviewArticles()) {
            abort(403, 'Hanya Kadiv atau Super Admin yang berwenang meninjau naskah ini.');
        }

        $fromStatus = $article->status;
        $article->update([
            'status' => 'under_review',
            'editor_id' => $user->id,
        ]);

        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => $fromStatus,
            'to_status' => 'under_review',
            'notes' => "Kadiv {$user->name} mulai memeriksa kelayakan naskah untuk terbit.",
        ]);

        ActivityLog::log('workflow_review', "Mulai meninjau naskah '{$article->title}'.", $article);

        return back()->with('success', 'Naskah kini sedang dalam peninjauan Kadiv.');
    }

    public function revisionRequired(Request $request, Article $article): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canPublishArticles()) {
            abort(403, 'Hanya Kadiv atau Super Admin yang dapat meminta revisi kepada Editor.');
        }

        $request->validate(['notes' => 'required|string|min:5|max:1000']);

        $fromStatus = $article->status;
        $article->update(['status' => 'revision_required']);

        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => $fromStatus,
            'to_status' => 'revision_required',
            'notes' => "Catatan Kadiv: " . $request->notes,
        ]);

        ActivityLog::log('workflow_revision', "Kadiv mengembalikan naskah '{$article->title}' kepada Editor untuk revisi.", $article);

        return back()->with('success', 'Catatan revisi telah dikirimkan kepada Editor untuk diperbaiki.');
    }

    public function approve(Article $article): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canPublishArticles()) {
            abort(403, 'Hanya Kadiv atau Super Admin yang berwenang menyetujui naskah.');
        }

        $fromStatus = $article->status;
        $article->update([
            'status' => 'approved',
            'editor_id' => $user->id,
        ]);

        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => $fromStatus,
            'to_status' => 'approved',
            'notes' => 'Naskah telah diverifikasi dan disetujui Kadiv, siap untuk diterbitkan.',
        ]);

        ActivityLog::log('workflow_approve', "Kadiv menyetujui naskah '{$article->title}'.", $article);

        return back()->with('success', 'Naskah disetujui Kadiv (Approved). Klik Terbitkan untuk menayangkan di website.');
    }

    public function publish(Request $request, Article $article): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canPublishArticles()) {
            abort(403, 'Hanya Kadiv atau Super Admin yang berwenang menerbitkan berita ke publik.');
        }

        $fromStatus = $article->status;
        $isScheduled = $request->filled('scheduled_for') && strtotime($request->scheduled_for) > time();

        $article->update([
            'status' => $isScheduled ? 'scheduled' : 'published',
            'published_at' => $isScheduled ? null : now(),
            'scheduled_for' => $isScheduled ? $request->scheduled_for : null,
            'editor_id' => $user->id,
        ]);

        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => $fromStatus,
            'to_status' => $isScheduled ? 'scheduled' : 'published',
            'notes' => $isScheduled ? "Kadiv menjadwalkan berita terbit pada {$request->scheduled_for}." : 'Kadiv menyetujui dan menerbitkan berita secara resmi ke website.',
        ]);

        ActivityLog::log('workflow_publish', "Menerbitkan berita '{$article->title}'.", $article);

        return back()->with('success', $isScheduled ? 'Berita berhasil dijadwalkan oleh Kadiv.' : 'Berita resmi disetujui dan tayang di portal publik Jurnalistik SPELAND.');
    }

    public function archive(Article $article): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canPublishArticles()) {
            abort(403);
        }

        $fromStatus = $article->status;
        $article->update(['status' => 'archived']);

        ArticleRevision::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'from_status' => $fromStatus,
            'to_status' => 'archived',
            'notes' => 'Berita dipindahkan ke arsip redaksi.',
        ]);

        ActivityLog::log('workflow_archive', "Mengarsipkan berita '{$article->title}'.", $article);

        return back()->with('success', 'Berita berhasil diarsipkan.');
    }
}
