<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $media = Media::with('user')->latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'caption' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $path = $file->store('media', 'public');

        $media = Media::create([
            'user_id' => auth()->id(),
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'caption' => $request->caption,
            'alt_text' => $request->alt_text,
        ]);

        ActivityLog::log('upload_media', "Mengunggah berkas media: {$media->filename}.", $media);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'media' => $media,
                'url' => asset('storage/' . $path),
            ]);
        }

        return back()->with('success', 'Foto berhasil diunggah ke Media Library.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        if (Storage::disk('public')->exists($media->filepath)) {
            Storage::disk('public')->delete($media->filepath);
        }

        $filename = $media->filename;
        $media->delete();

        ActivityLog::log('delete_media', "Menghapus media {$filename}.");

        return back()->with('success', 'Media berhasil dihapus.');
    }
}
