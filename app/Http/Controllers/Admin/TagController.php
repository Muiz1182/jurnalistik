<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::withCount('articles')->orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:tags',
        ]);

        $tag = Tag::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        ActivityLog::log('create_tag', "Menambahkan tag baru #{$tag->name}.", $tag);

        return back()->with('success', 'Tag berhasil ditambahkan.');
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => "required|string|max:50|unique:tags,name,{$tag->id}",
        ]);

        $tag->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        ActivityLog::log('update_tag', "Memperbarui tag #{$tag->name}.", $tag);

        return back()->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $name = $tag->name;
        $tag->articles()->detach();
        $tag->delete();

        ActivityLog::log('delete_tag', "Menghapus tag #{$name}.");

        return back()->with('success', 'Tag berhasil dihapus.');
    }
}
