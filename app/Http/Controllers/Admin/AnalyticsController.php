<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        // 1. Most read articles
        $topArticles = Article::published()
            ->with(['category', 'author'])
            ->orderByDesc('views_count')
            ->take(10)
            ->get();

        // 2. Category article distribution
        $categoryStats = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        // 3. Reporter productivity
        $reporterStats = User::whereHas('role', fn($q) => $q->whereIn('slug', ['reporter', 'fotografer', 'editor']))
            ->withCount(['articles as published_count' => fn($q) => $q->where('status', 'published')])
            ->withCount(['articles as draft_count' => fn($q) => $q->where('status', 'draft')])
            ->withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        // 4. Daily view trends over the last 14 days from PostgreSQL
        $dailyViews = ArticleView::selectRaw('viewed_date, count(*) as total_views')
            ->where('viewed_date', '>=', now()->subDays(14)->toDateString())
            ->groupBy('viewed_date')
            ->orderBy('viewed_date')
            ->get();

        // 5. Total counts
        $totalViews = (int) Article::sum('views_count');
        $totalArticles = Article::count();
        $publishedCount = Article::where('status', 'published')->count();

        return view('admin.analytics.index', compact(
            'topArticles',
            'categoryStats',
            'reporterStats',
            'dailyViews',
            'totalViews',
            'totalArticles',
            'publishedCount'
        ));
    }
}
