<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\SpecialCoverage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SpecialCoverageController extends Controller
{
    public function index(): View
    {
        $coverages = SpecialCoverage::withCount('articles')->latest()->paginate(10);
        return view('admin.special-coverages.index', compact('coverages'));
    }

    public function create(): View
    {
        $articles = Article::published()->latest('published_at')->get();
        return view('admin.special-coverages.create', compact('articles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'article_ids' => 'nullable|array',
            'article_ids.*' => 'exists:articles,id',
            'is_active' => 'nullable|boolean',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('coverages', 'public');
        }

        $coverage = SpecialCoverage::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'banner_image' => $bannerPath,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if (!empty($validated['article_ids'])) {
            foreach ($validated['article_ids'] as $order => $artId) {
                $coverage->articles()->attach($artId, ['order' => $order + 1]);
            }
        }

        ActivityLog::log('create_coverage', "Membuat liputan khusus '{$coverage->title}'.", $coverage);

        return redirect()->route('admin.special-coverages.index')->with('success', 'Liputan khusus berhasil dibuat.');
    }

    public function edit(SpecialCoverage $specialCoverage): View
    {
        $articles = Article::published()->latest('published_at')->get();
        $selectedArticleIds = $specialCoverage->articles->pluck('id')->toArray();

        return view('admin.special-coverages.edit', compact('specialCoverage', 'articles', 'selectedArticleIds'));
    }

    public function update(Request $request, SpecialCoverage $specialCoverage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'article_ids' => 'nullable|array',
            'article_ids.*' => 'exists:articles,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($specialCoverage->banner_image && !Str::startsWith($specialCoverage->banner_image, 'http')) {
                Storage::disk('public')->delete($specialCoverage->banner_image);
            }
            $specialCoverage->banner_image = $request->file('banner_image')->store('coverages', 'public');
        }

        $specialCoverage->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $syncData = [];
        if (!empty($validated['article_ids'])) {
            foreach ($validated['article_ids'] as $order => $artId) {
                $syncData[$artId] = ['order' => $order + 1];
            }
        }
        $specialCoverage->articles()->sync($syncData);

        ActivityLog::log('update_coverage', "Memperbarui liputan khusus '{$specialCoverage->title}'.", $specialCoverage);

        return redirect()->route('admin.special-coverages.index')->with('success', 'Liputan khusus berhasil diperbarui.');
    }

    public function destroy(SpecialCoverage $specialCoverage): RedirectResponse
    {
        $title = $specialCoverage->title;
        $specialCoverage->articles()->detach();
        $specialCoverage->delete();

        ActivityLog::log('delete_coverage', "Menghapus liputan khusus '{$title}'.");

        return back()->with('success', 'Liputan khusus berhasil dihapus.');
    }
}
