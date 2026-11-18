<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Podcast;
use App\Models\SpecialCoverage;
use App\Models\Video;
use Illuminate\View\View;

class MultimediaController extends Controller
{
    public function galleries(): View
    {
        $galleries = Gallery::where('is_published', true)
            ->with(['user', 'photos'])
            ->withCount('photos')
            ->latest()
            ->paginate(9);

        return view('pages.multimedia.galleries', compact('galleries'));
    }

    public function galleryShow(string $slug): View
    {
        $gallery = Gallery::where('slug', $slug)
            ->where('is_published', true)
            ->with(['user', 'photos'])
            ->firstOrFail();

        $gallery->increment('views_count');

        $otherGalleries = Gallery::where('is_published', true)
            ->where('id', '!=', $gallery->id)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.multimedia.gallery-show', compact('gallery', 'otherGalleries'));
    }

    public function videos(): View
    {
        $videos = Video::where('is_published', true)
            ->with('user')
            ->latest('published_at')
            ->paginate(9);

        return view('pages.multimedia.videos', compact('videos'));
    }

    public function podcasts(): View
    {
        $podcasts = Podcast::where('is_published', true)
            ->with('user')
            ->orderBy('episode_number', 'desc')
            ->paginate(8);

        return view('pages.multimedia.podcasts', compact('podcasts'));
    }

    public function specialCoverages(): View
    {
        $coverages = SpecialCoverage::where('is_active', true)
            ->withCount('articles')
            ->latest()
            ->paginate(6);

        return view('pages.multimedia.special-coverages', compact('coverages'));
    }

    public function specialCoverageShow(string $slug): View
    {
        $coverage = SpecialCoverage::where('slug', $slug)
            ->where('is_active', true)
            ->with(['articles.category', 'articles.author'])
            ->firstOrFail();

        return view('pages.multimedia.special-coverage-show', compact('coverage'));
    }
}
