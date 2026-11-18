<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Podcast;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PodcastController extends Controller
{
    public function index(): View
    {
        $podcasts = Podcast::with('user')->orderByDesc('episode_number')->paginate(12);
        return view('admin.podcasts.index', compact('podcasts'));
    }

    public function create(): View
    {
        $nextEpisode = (Podcast::max('episode_number') ?? 0) + 1;
        return view('admin.podcasts.create', compact('nextEpisode'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'episode_number' => 'required|integer',
            'host' => 'required|string|max:100',
            'guest' => 'nullable|string|max:100',
            'youtube_url' => 'nullable|url',
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $youtubeId = $request->filled('youtube_url') ? Video::extractYoutubeId($validated['youtube_url']) : null;

        $podcast = Podcast::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'episode_number' => $validated['episode_number'],
            'host' => $validated['host'],
            'guest' => $validated['guest'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'youtube_id' => $youtubeId,
            'duration' => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'user_id' => auth()->id(),
            'published_at' => $validated['published_at'] ?? now(),
            'is_published' => $request->boolean('is_published', true),
        ]);

        ActivityLog::log('create_podcast', "Menambahkan episode podcast #{$podcast->episode_number}: {$podcast->title}.", $podcast);

        return redirect()->route('admin.podcasts.index')->with('success', 'Episode podcast berhasil ditambahkan.');
    }

    public function edit(Podcast $podcast): View
    {
        return view('admin.podcasts.edit', compact('podcast'));
    }

    public function update(Request $request, Podcast $podcast): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'episode_number' => 'required|integer',
            'host' => 'required|string|max:100',
            'guest' => 'nullable|string|max:100',
            'youtube_url' => 'nullable|url',
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $youtubeId = $request->filled('youtube_url') ? Video::extractYoutubeId($validated['youtube_url']) : null;

        $podcast->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'episode_number' => $validated['episode_number'],
            'host' => $validated['host'],
            'guest' => $validated['guest'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'youtube_id' => $youtubeId,
            'duration' => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'published_at' => $validated['published_at'] ?? $podcast->published_at,
            'is_published' => $request->boolean('is_published', true),
        ]);

        ActivityLog::log('update_podcast', "Memperbarui episode podcast #{$podcast->episode_number}.", $podcast);

        return redirect()->route('admin.podcasts.index')->with('success', 'Episode podcast berhasil diperbarui.');
    }

    public function destroy(Podcast $podcast): RedirectResponse
    {
        $title = $podcast->title;
        $podcast->delete();

        ActivityLog::log('delete_podcast', "Menghapus podcast '{$title}'.");

        return back()->with('success', 'Episode podcast berhasil dihapus.');
    }
}
