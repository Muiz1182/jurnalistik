<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\EditorialMember;
use App\Models\Gallery;
use App\Models\Podcast;
use App\Models\Setting;
use App\Models\SpecialCoverage;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 1. Breaking News
        $breakingNews = Article::breaking()->with(['category'])->take(5)->get();

        // 2. Hero Headline (Editor-selected headline -> featured -> latest published)
        $heroHeadline = Article::headlines()->with(['category', 'author'])->first();
        if (!$heroHeadline) {
            $heroHeadline = Article::featured()->with(['category', 'author'])->first();
        }
        if (!$heroHeadline) {
            $heroHeadline = Article::published()->with(['category', 'author'])->latest('published_at')->first();
        }

        // 3. Featured Secondary Articles (Sorotan Redaksi / Pilihan Editor)
        $excludeIds = $heroHeadline ? [$heroHeadline->id] : [];
        $secondaryHeadlines = Article::published()
            ->whereNotIn('id', $excludeIds)
            ->with(['category', 'author'])
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->take(3)
            ->get();

        $excludeIds = array_merge($excludeIds, $secondaryHeadlines->pluck('id')->toArray());

        // 4. Latest News (Kabar Terkini Berita Sekolah)
        $latestArticles = Article::published()
            ->whereNotIn('id', $excludeIds)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(6)
            ->get();

        // 5. Popular News (Berita Terpopuler with smart recency & backfill)
        $popularArticles = Article::getPopular(5);

        // 6. Articles by Category Highlights (Rubrikasi Utama Beranda)
        $pendidikanArticles = Article::published()
            ->whereHas('category', fn($q) => $q->where('slug', 'pendidikan'))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        $prestasiArticles = Article::published()
            ->whereHas('category', fn($q) => $q->where('slug', 'prestasi'))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        $kegiatanArticles = Article::published()
            ->whereHas('category', fn($q) => $q->where('slug', 'kegiatan'))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        $lingkunganArticles = Article::published()
            ->whereHas('category', fn($q) => $q->where('slug', 'lingkungan'))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        // 7. Opini & Esai Murid / Guru
        $opiniArticles = Article::published()
            ->whereHas('category', fn($q) => $q->where('slug', 'opini'))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(3)
            ->get();

        // 8. Multimedia
        $galleries = Gallery::where('is_published', true)->withCount('photos')->latest()->take(3)->get();
        $videos = Video::where('is_published', true)->latest('published_at')->take(3)->get();
        $podcasts = Podcast::where('is_published', true)->latest('published_at')->take(2)->get();
        $specialCoverage = SpecialCoverage::where('is_active', true)->with('articles.category')->latest()->first();

        // 9. Categories for Navigation
        $navCategories = Category::where('is_active', true)
            ->where('show_in_navbar', true)
            ->orderBy('order')
            ->get();

        return view('pages.home', compact(
            'breakingNews',
            'heroHeadline',
            'secondaryHeadlines',
            'latestArticles',
            'popularArticles',
            'pendidikanArticles',
            'prestasiArticles',
            'kegiatanArticles',
            'lingkunganArticles',
            'opiniArticles',
            'galleries',
            'videos',
            'podcasts',
            'specialCoverage',
            'navCategories'
        ));
    }

    public function about(): View
    {
        $members = EditorialMember::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->groupBy('division');

        return view('pages.about', compact('members'));
    }

    public function editorialStructure(): View
    {
        $members = EditorialMember::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->groupBy('division');

        return view('pages.editorial-structure', compact('members'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function editorialPolicy(): View
    {
        return view('pages.editorial-policy');
    }

    public function journalisticGuidelines(): View
    {
        return view('pages.journalistic-guidelines');
    }
}
