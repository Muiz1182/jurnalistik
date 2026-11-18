<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::published()->with(['category', 'author']);

        if ($request->filled('kategori')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->filled('urutan')) {
            if ($request->urutan === 'populer') {
                $query->orderByDesc('views_count');
            } else {
                $query->latest('published_at');
            }
        } else {
            $query->latest('published_at');
        }

        $articles = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $popularArticles = Article::popular(30)->take(5)->get();

        return view('pages.articles.index', compact('articles', 'categories', 'popularArticles'));
    }

    public function show(Request $request, string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->with(['category', 'author', 'editor', 'tags', 'approvedComments.user'])
            ->firstOrFail();

        // If not published, only editorial staff can preview
        if ($article->status !== 'published') {
            if (!auth()->check() || !auth()->user()->isReporter()) {
                abort(404);
            }
        } else {
            // Track view with deduplication (session or IP per day)
            ArticleView::track($article, $request->ip(), $request->session()->getId());
        }

        // Related articles from same category
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        // Popular sidebar articles
        $popularArticles = Article::popular(30)
            ->where('id', '!=', $article->id)
            ->take(5)
            ->get();

        $isBookmarked = auth()->check() ? $article->isBookmarkedBy(auth()->user()) : false;

        return view('pages.articles.show', compact('article', 'relatedArticles', 'popularArticles', 'isBookmarked'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['author', 'tags'])
            ->latest('published_at')
            ->paginate(10);

        $popularArticles = Article::popular(30)->take(5)->get();

        return view('pages.articles.category', compact('category', 'articles', 'popularArticles'));
    }

    public function popular(): View
    {
        $articles = Article::popular(30)
            ->with(['category', 'author'])
            ->paginate(12);

        return view('pages.articles.popular', compact('articles'));
    }

    public function latest(): View
    {
        $articles = Article::published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12);

        return view('pages.articles.latest', compact('articles'));
    }

    public function opinion(): View
    {
        $opiniCategory = Category::where('slug', 'opini')->first();
        
        $articles = Article::published()
            ->when($opiniCategory, fn($q) => $q->where('category_id', $opiniCategory->id))
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(10);

        $popularArticles = Article::popular(30)->take(5)->get();

        return view('pages.articles.opinion', compact('articles', 'popularArticles'));
    }

    public function search(Request $request): View
    {
        $q = $request->input('q', '');
        $categoryId = $request->input('kategori');
        $sort = $request->input('urutan', 'relevansi');

        $query = Article::published()->with(['category', 'author']);

        if (!empty($q)) {
            $query->search($q);
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if ($sort === 'terbaru') {
            $query->latest('published_at');
        } elseif ($sort === 'terpopuler') {
            $query->orderByDesc('views_count');
        }

        $articles = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $popularArticles = Article::popular(30)->take(5)->get();

        return view('pages.articles.search', compact('articles', 'q', 'categories', 'popularArticles'));
    }

    public function archive(Request $request): View
    {
        $year = $request->input('tahun', date('Y'));
        $month = $request->input('bulan', date('m'));

        $articles = Article::published()
            ->whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('pages.articles.archive', compact('articles', 'year', 'month'));
    }

    public function toggleBookmark(Request $request, Article $article): JsonResponse|RedirectResponse
    {
        if (!auth()->check()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan masuk untuk menyimpan artikel.');
        }

        $user = auth()->user();
        $existing = Bookmark::where('user_id', $user->id)->where('article_id', $article->id)->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
            $message = 'Artikel dihapus dari simpanan.';
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
            ]);
            $bookmarked = true;
            $message = 'Artikel berhasil disimpan ke daftar bacaan.';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'bookmarked' => $bookmarked,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function myBookmarks(): View
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with(['article.category', 'article.author'])
            ->latest()
            ->paginate(10);

        return view('pages.articles.bookmarks', compact('bookmarks'));
    }
}
