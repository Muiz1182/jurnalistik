<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('articles')->orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:20',
            'order' => 'nullable|integer',
            'show_in_navbar' => 'nullable|boolean',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'],
            'order' => $validated['order'] ?? 0,
            'show_in_navbar' => $request->boolean('show_in_navbar', true),
            'is_active' => true,
        ]);

        ActivityLog::log('create_category', "Membuat kategori baru '{$category->name}'.", $category);

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => "required|string|max:100|unique:categories,name,{$category->id}",
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:20',
            'order' => 'nullable|integer',
            'show_in_navbar' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'],
            'order' => $validated['order'] ?? $category->order,
            'show_in_navbar' => $request->boolean('show_in_navbar'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLog::log('update_category', "Memperbarui kategori '{$category->name}'.", $category);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->articles()->exists()) {
            return back()->with('error', 'Kategori ini memiliki artikel terkait dan tidak dapat dihapus.');
        }

        $name = $category->name;
        $category->delete();

        ActivityLog::log('delete_category', "Menghapus kategori '{$name}'.");

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
