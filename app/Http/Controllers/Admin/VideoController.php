<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        $videos = Video::with('user')->latest()->paginate(12);
        return view('admin.videos.index', compact('videos'));
    }

    public function create(): View
    {
        return view('admin.videos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $youtubeId = Video::extractYoutubeId($validated['youtube_url']);

        $video = Video::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'youtube_url' => $validated['youtube_url'],
            'youtube_id' => $youtubeId,
            'category' => $validated['category'],
            'user_id' => auth()->id(),
            'published_at' => $validated['published_at'] ?? now(),
            'is_published' => $request->boolean('is_published', true),
        ]);

        ActivityLog::log('create_video', "Menambahkan video '{$video->title}'.", $video);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video): View
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $youtubeId = Video::extractYoutubeId($validated['youtube_url']);

        $video->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'youtube_url' => $validated['youtube_url'],
            'youtube_id' => $youtubeId,
            'category' => $validated['category'],
            'published_at' => $validated['published_at'] ?? $video->published_at,
            'is_published' => $request->boolean('is_published', true),
        ]);

        ActivityLog::log('update_video', "Memperbarui video '{$video->title}'.", $video);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video): RedirectResponse
    {
        $title = $video->title;
        $video->delete();

        ActivityLog::log('delete_video', "Menghapus video '{$title}'.");

        return back()->with('success', 'Video berhasil dihapus.');
    }
}
