<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\Comment;
use App\Models\EditorialAssignment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Real Data Metrics from PostgreSQL
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'submitted_to_kadiv' => Article::where('status', 'submitted')->count(),
            'under_review_articles' => Article::whereIn('status', ['submitted', 'under_review'])->count(),
            'revision_required' => Article::where('status', 'revision_required')->count(),
            'total_views' => (int) Article::sum('views_count'),
            'total_reporters' => User::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'my_articles_count' => Article::where('user_id', $user->id)->count(),
            'my_drafts' => Article::where('user_id', $user->id)->where('status', 'draft')->count(),
            'my_submitted' => Article::where('user_id', $user->id)->where('status', 'submitted')->count(),
            'my_revisions' => Article::where('user_id', $user->id)->where('status', 'revision_required')->count(),
            'my_published' => Article::where('user_id', $user->id)->where('status', 'published')->count(),
        ];

        // Popular Articles
        $popularArticles = Article::published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // Articles waiting for review / attention
        $reviewQueueQuery = Article::whereIn('status', ['submitted', 'under_review', 'revision_required'])
            ->with(['author', 'category']);

        if ($user->hasRole('editor')) {
            $reviewQueueQuery->where('user_id', $user->id);
        }

        $reviewQueue = $reviewQueueQuery->latest('updated_at')
            ->take(6)
            ->get();

        // Recent System Activity
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Monthly publication trend (last 6 months from PostgreSQL)
        $monthlyStats = Article::published()
            ->selectRaw("to_char(published_at, 'Mon YYYY') as month, count(*) as count")
            ->where('published_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("to_char(published_at, 'Mon YYYY')"))
            ->get();

        // Pending assignments for reporter
        $myAssignments = EditorialAssignment::where('reporter_id', $user->id)
            ->whereIn('status', ['assigned', 'in_progress'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'popularArticles',
            'reviewQueue',
            'recentActivities',
            'monthlyStats',
            'myAssignments'
        ));
    }
}
