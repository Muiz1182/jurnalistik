<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::with('user')->withCount('photos')->latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'captions' => 'nullable|array',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('galleries/covers', 'public');
        }

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],
            'cover_image' => $coverPath,
            'user_id' => auth()->id(),
            'is_published' => true,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photoFile) {
                $photoPath = $photoFile->store('galleries/photos', 'public');
                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $photoPath,
                    'caption' => $request->captions[$index] ?? null,
                    'photographer' => auth()->user()->name,
                    'order' => $index + 1,
                ]);
            }
        }

        ActivityLog::log('create_gallery', "Membuat album galeri '{$gallery->title}'.", $gallery);

        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri berhasil dibuat.');
    }

    public function edit(Gallery $gallery): View
    {
        $gallery->load('photos');
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'captions' => 'nullable|array',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image && !Str::startsWith($gallery->cover_image, 'http')) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $gallery->cover_image = $request->file('cover_image')->store('galleries/covers', 'public');
        }

        $gallery->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],
            'is_published' => $request->boolean('is_published', true),
        ]);

        if ($request->hasFile('photos')) {
            $nextOrder = $gallery->photos()->max('order') ?? 0;
            foreach ($request->file('photos') as $index => $photoFile) {
                $photoPath = $photoFile->store('galleries/photos', 'public');
                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $photoPath,
                    'caption' => $request->captions[$index] ?? null,
                    'photographer' => auth()->user()->name,
                    'order' => ++$nextOrder,
                ]);
            }
        }

        ActivityLog::log('update_gallery', "Memperbarui album galeri '{$gallery->title}'.", $gallery);

        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri berhasil diperbarui.');
    }

    public function destroyPhoto(GalleryPhoto $photo): RedirectResponse
    {
        if (Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }
        $photo->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        foreach ($gallery->photos as $photo) {
            if (Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }
        }

        $title = $gallery->title;
        $gallery->delete();

        ActivityLog::log('delete_gallery', "Menghapus album galeri '{$title}'.");

        return back()->with('success', 'Album galeri berhasil dihapus.');
    }
}
